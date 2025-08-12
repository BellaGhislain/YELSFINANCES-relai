<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function index()
    {
        // Récupérer les 3 dernières formations actives avec leurs sessions
        // Utiliser la même logique simple que getSessions()
        $sessions = Session::with(['formation', 'trainers'])
            ->whereHas('formation', function ($query) {
                $query->where('is_active', true);
            })
            ->whereIn('status', ['en attente', 'en cours'])
            ->take(3)
            ->get();

        $formations = $sessions->map(function ($session) {
            return [
                'id' => $session->id,
                'title' => $session->formation->name,
                'description' => $session->formation->presentation,
                'level' => $session->formation->level,
                'price' => $session->price,
                'duration' => $this->calculateDuration($session->start_date, $session->end_date),
                'students' => $session->orderDetails->count(),
                'start_date' => Carbon::parse($session->start_date)->format('Y-m-d'),
                'location' => $session->city . ', ' . $session->country,
                'type' => $session->type,
                'image' => $session->formation->photo ? asset('assets/images/' . $session->formation->photo) : 'https://via.placeholder.com/800',
                'badge' => 'Recommandé',
                'youtube_link' => $session->formation->youtube_link,
            ];
        });

        return view('client.index', [
            'pageTitle' => 'Accueil',
            'formations' => $formations
        ]);
    }

    public function getSessions()
    {
        $sessions = Session::with(['formation', 'trainers'])
            ->whereHas('formation', function ($query) {
                $query->where('is_active', true);
            })
            ->whereIn('status', ['en attente', 'en cours'])
            ->get();

        return response()->json([
            'sessions' => $sessions->map(function ($session) {
                return [
                    'id' => $session->id,
                    'title' => $session->formation->name,
                    'description' => $session->formation->presentation,
                    'longDescription' => $session->formation->presentation,
                    'category' => $this->mapLevelToCategory($session->formation->level),
                    'price' => $session->price,
                    'originalPrice' => $session->price * 1.2,
                    'duration' => $this->calculateDuration($session->start_date, $session->end_date),
                    'level' => $session->formation->level,
                    'students' => $session->orderDetails->count(),
                    'rating' => 4.8,
                    'session' => Carbon::parse($session->start_date)->locale('fr')->translatedFormat('d F'),
                    'start_date' => Carbon::parse($session->start_date)->locale('fr')->translatedFormat('d F Y'),
                    'end_date' => Carbon::parse($session->end_date)->locale('fr')->translatedFormat('d F Y'),
                    'instructor' => $session->trainers->pluck('first_name')->implode(', ') ?: 'Formateur non spécifié',
                    'image' => $session->formation->photo ? asset('assets/images/' . $session->formation->photo) : 'https://via.placeholder.com/800',
                    'features' => $session->formation->skills->pluck('name')->toArray(),
                    'youtube_link' => $session->formation->youtube_link,
                    'photo' => $session->formation->photo ? \Storage::url($session->formation->photo) : null,
                    'status' => $session->status,
                    'country' => $session->country,
                    'city' => $session->city,
                    'type' => $session->type,
                ];
            })
        ]);
    }

    private function mapLevelToCategory($level)
    {
        $mapping = [
            'Débutant' => 'marketing',
            'Intermédiaire' => 'web',
            'Avancé' => 'data',
        ];
        return $mapping[$level] ?? 'design';
    }

    private function calculateDuration($startDate, $endDate)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        $days = $start->diffInDays($end) + 1;
        return $days <= 7 ? "$days jours" : ceil($days / 7) . " semaines";
    }

    private function getFormationBadge($formation, $session)
    {
        // Logique pour déterminer le badge de la formation
        $badges = ['Populaire', 'Nouveau', 'Promo', 'Recommandé'];
        
        // Si c'est une formation récente (créée dans les 30 derniers jours)
        if ($formation->created_at->diffInDays(now()) <= 30) {
            return 'Nouveau';
        }
        
        // Si c'est une formation avec beaucoup d'étudiants
        if (rand(1, 100) > 80) {
            return 'Populaire';
        }
        
        // Si c'est une formation en promo (prix réduit)
        if (rand(1, 100) > 90) {
            return 'Promo';
        }
        
        // Par défaut
        return 'Recommandé';
    }

    public function getCart()
    {
        $cart = session()->get('cart', []);
        return response()->json(['cart' => array_values($cart)]);
    }

    public function addToCart(Request $request)
    {
        $sessionId = $request->input('session_id');
        $session = Session::with(['formation', 'trainers'])->findOrFail($sessionId);
        $cart = session()->get('cart', []);

        if (isset($cart[$sessionId])) {
            return response()->json(['message' => 'Cette session a été ajoutée dans le panier', 'cart' => array_values($cart)]);
        }

        $cart[$sessionId] = [
            'id' => $session->id,
            'title' => $session->formation->name,
            'price' => $session->price,
            'quantity' => ($cart[$sessionId]['quantity'] ?? 0) + 1,
            'image' => $session->formation->photo ? asset('assets/images/' . $session->formation->photo) : 'https://via.placeholder.com/800',
            'session' => \Carbon\Carbon::parse($session->start_date)->locale('fr')->format('d F'),
            'instructor' => $session->trainers->pluck('first_name')->implode(', ') ?: 'Formateur non spécifié',
        ];

        session()->put('cart', $cart);
        return response()->json(['message' => 'Session ajoutée au panier', 'cart' => array_values($cart)]);
    }

    public function removeFromCart(Request $request)
    {
        $sessionId = $request->input('session_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$sessionId])) {
            unset($cart[$sessionId]);
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Session retirée du panier', 'cart' => array_values($cart)]);
    }

    public function clearCart(Request $request)
    {
        session()->forget('cart');
        return response()->json(['message' => 'Panier vidé', 'cart' => []]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'Le panier est vide'], 400);
        }

        // Créer la commande
        $order = new Order();
        $order->first_name = $request->firstName;
        $order->last_name = $request->lastName;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->company = $request->company;
        $order->country = $request->country;
        $order->total_price = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $order->status = 'pending';
        $order->save();

        // Enregistrer les détails de la commande
        foreach ($cart as $sessionId => $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'session_id' => $sessionId,
                'formation_id' => Session::find($sessionId)->formation->id,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Appeler l'API CoolPay pour créer une transaction
        $response = Http::post('https://my-coolpay.com/api/' . config('services.coolpay.public_key') . '/paylink', [
            'transaction_amount' => $order->total_price,
            'transaction_currency' => 'EUR',
            'transaction_reason' => 'Achat de formations - YEL\'S FINANCES',
            'app_transaction_ref' => 'FP' . $order->id,
            'customer_phone_number' => $order->phone ?? '',
            'customer_name' => $order->first_name . ' ' . $order->last_name,
            'customer_email' => $order->email,
            'customer_lang' => 'fr',
        ]);

        if ($response->failed()) {
            $order->status = 'failed';
            $order->save();
            return response()->json(['error' => 'Erreur lors de la création de la transaction de paiement'], 500);
        }

        $paymentData = $response->json();
        $paymentUrl = $paymentData['payment_url'] ?? null;

        if (!$paymentUrl) {
            $order->status = 'failed';
            $order->save();
            return response()->json(['error' => 'Impossible d’obtenir l’URL de paiement'], 500);
        }

        // Enregistrer la transaction dans la table payments
        Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'status' => 'pending',
            'payment_method' => 'CoolPay',
            'transaction_id' => $paymentData['transaction_ref'] ?? null,
        ]);

        // Vider le panier
        session()->forget('cart');

        return response()->json([
            'message' => 'Commande créée, redirection vers le paiement',
            'orderId' => 'FP' . $order->id,
            'paymentUrl' => $paymentUrl,
        ]);
    }

    public function handleCoolPayWebhook(Request $request)
    {
        // Vérifier la signature du webhook (optionnel, selon CoolPay)
        $signature = $request->header('X-CoolPay-Signature');
        if ($signature) {
            $expectedSignature = hash_hmac('sha256', $request->getContent(), config('services.coolpay.webhook_secret'));
            if ($signature !== $expectedSignature) {
                return response()->json(['error' => 'Signature invalide'], 403);
            }
        }

        $data = $request->all();
        $orderId = str_replace('FP', '', $data['app_transaction_ref'] ?? $data['order_id'] ?? '');
        $status = $data['status'] ?? '';
        $transactionId = $data['transaction_ref'] ?? $data['transaction_id'] ?? null;

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Commande non trouvée'], 404);
        }

        $payment = Payment::where('order_id', $orderId)->first();
        if (!$payment) {
            return response()->json(['error' => 'Paiement non trouvé'], 404);
        }

        // Mettre à jour la commande et le paiement
        if ($status === 'success') {
            $order->status = 'completed';
            $payment->status = 'completed';
            $payment->transaction_id = $transactionId ?? $payment->transaction_id;
            $order->save();
            $payment->save();

            // Envoyer l'e-mail de confirmation
            Mail::to($order->email)->send(new OrderConfirmation($order));
        } elseif ($status === 'failed') {
            $order->status = 'failed';
            $payment->status = 'failed';
            $payment->transaction_id = $transactionId ?? $payment->transaction_id;
            $order->save();
            $payment->save();
        }

        return response()->json(['message' => 'Webhook traité avec succès']);
    }

    public function formation()
    {
        return view('client.formation', ['pageTitle' => 'Formations']);
    }

    public function aPropos()
    {
        return view('client.a-propos', ['pageTitle' => 'À Propos']);
    }

    public function contact()
    {
        return view('client.contact', ['pageTitle' => 'Contact']);
    }


}
