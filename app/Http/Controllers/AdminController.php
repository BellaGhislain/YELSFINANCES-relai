<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Session;
use App\Models\Trainer;
use App\Models\Skill;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

      public function getSessionStats()
    {
        try {
            // Dates pour le mois en cours et le mois précédent
            $startOfCurrentMonth = Carbon::now()->startOfMonth();
            $endOfCurrentMonth = Carbon::now();
            $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();

            // Nombre total d'apprenants uniques (basé sur email)
            $learnersCount = Order::distinct('email')->count('email') ?? 0;
            // Apprenants ajoutés ce mois
            $learnersThisMonth = Order::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                ->distinct('email')
                ->count('email') ?? 0;
            // Apprenants le mois précédent
            $learnersLastMonth = Order::whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
                ->distinct('email')
                ->count('email') ?? 0;
            // Pourcentage d'évolution des apprenants
            $learnersGrowth = $learnersLastMonth > 0
                ? round((($learnersThisMonth - $learnersLastMonth) / $learnersLastMonth) * 100, 1)
                : ($learnersThisMonth > 0 ? 100 : 0);

            // Total des paiements complétés
            $totalPayments = Payment::where('status', 'completed')->sum('amount') ?? 0;
            // Paiements ce mois
            $paymentsThisMonth = Payment::where('status', 'completed')
                ->whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                ->sum('amount') ?? 0;
            // Paiements le mois précédent
            $paymentsLastMonth = Payment::where('status', 'completed')
                ->whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
                ->sum('amount') ?? 0;
            // Pourcentage d'évolution des paiements
            $paymentsGrowth = $paymentsLastMonth > 0
                ? round((($paymentsThisMonth - $paymentsLastMonth) / $paymentsLastMonth) * 100, 1)
                : ($paymentsThisMonth > 0 ? 100 : 0);

            // Nombre de sessions en cours
            $ongoingSessions = Session::where('status', 'en cours')->count() ?? 0;
            // Sessions démarrées ce mois
            $sessionsThisMonth = Session::where('status', 'en cours')
                ->whereBetween('start_date', [$startOfCurrentMonth, $endOfCurrentMonth])
                ->count() ?? 0;
            // Sessions démarrées le mois précédent
            $sessionsLastMonth = Session::where('status', 'en cours')
                ->whereBetween('start_date', [$startOfPreviousMonth, $endOfPreviousMonth])
                ->count() ?? 0;
            // Pourcentage d'évolution des sessions
            $sessionsGrowth = $sessionsLastMonth > 0
                ? round((($sessionsThisMonth - $sessionsLastMonth) / $sessionsLastMonth) * 100, 1)
                : ($sessionsThisMonth > 0 ? 100 : 0);

            return response()->json([
                'learners_count' => $learnersCount,
                'learners_this_month' => $learnersThisMonth,
                'learners_growth' => $learnersGrowth,
                'total_payments' => $totalPayments >= 1000000
                    ? number_format($totalPayments / 1000000, 1, ',', ' ') . 'M'
                    : number_format($totalPayments, 0, ',', ' ') . ' €',
                'payments_this_month' => $paymentsThisMonth >= 1000000
                    ? number_format($paymentsThisMonth / 1000000, 1, ',', ' ') . 'M'
                    : number_format($paymentsThisMonth, 0, ',', ' ') . ' €',
                'payments_growth' => $paymentsGrowth,
                'ongoing_sessions' => $ongoingSessions,
                'sessions_this_month' => $sessionsThisMonth,
                'sessions_growth' => $sessionsGrowth,
            ], 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            Log::error('Erreur dans getSessionStats: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des statistiques.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Formations
    public function formations()
    {
        $formations = Formation::with('skills')->orderBy('name', 'asc')->get();
        return view('admin.formations.index', compact('formations'));
    }

    public function showFormation(Formation $formation)
    {
        return view('admin.formations.show', compact('formation'));
    }

    public function createFormation()
    {
        return view('admin.formations.create');
    }

    public function storeFormation(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'level' => 'required|in:debutant,intermediaire,avance,expert',
            'skillItem' => 'required|array',
            'skillItem.*' => 'required|string|max:255',
            'presentation' => 'required|string',
            'youtube_link' => 'nullable|url',
            'photo' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ];

        $messages = [
            'photo.max' => 'L\'image est trop volumineuse. La taille maximale autorisée est de 2 Mo.',
            'photo.mimes' => 'Le fichier doit être une image au format JPG, PNG ou GIF.',
            'photo.image' => 'Le fichier doit être une image valide.',
        ];

        $validated = $request->validate($rules, $messages);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $originalImage = $request->file('photo');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $originalImage->getClientOriginalName());
            $image = Image::make($originalImage)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 75);
            $photoPath = 'formations/' . $filename;
            Storage::disk('public')->put($photoPath, (string) $image);
        }

        $formation = Formation::create([
            'name' => $validated['name'],
            'level' => $validated['level'],
            'presentation' => $validated['presentation'],
            'youtube_link' => $validated['youtube_link'],
            'photo' => $photoPath,
        ]);

        $skillIds = collect($validated['skillItem'])->map(function ($skillName) {
            return Skill::firstOrCreate(['name' => $skillName])->id;
        })->all();
        $formation->skills()->sync($skillIds);

        return redirect()->route('admin.formations')->with('success', 'Formation créée avec succès.');
    }

    public function editFormation(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function updateFormation(Request $request, Formation $formation)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'level' => 'required|in:debutant,intermediaire,avance,expert',
            'skillItem' => 'required|array',
            'skillItem.*' => 'required|string|max:255',
            'presentation' => 'required|string',
            'youtube_link' => 'nullable|url',
            'photo' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ];

        $messages = [
            'photo.max' => 'L\'image est trop volumineuse. La taille maximale autorisée est de 2 Mo.',
            'photo.mimes' => 'Le fichier doit être une image au format JPG, PNG ou GIF.',
            'photo.image' => 'Le fichier doit être une image valide.',
        ];

        $validated = $request->validate($rules, $messages);

        if ($request->hasFile('photo')) {
            if ($formation->photo) {
                Storage::disk('public')->delete($formation->photo);
            }
            $image = $request->file('photo');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $image = Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 75);
            $photoPath = 'formations/' . $filename;
            Storage::disk('public')->put($photoPath, (string) $image);
            $validated['photo'] = $photoPath;
        } else {
            $validated['photo'] = $formation->photo;
        }

        $formation->update([
            'name' => $validated['name'],
            'level' => $validated['level'],
            'presentation' => $validated['presentation'],
            'youtube_link' => $validated['youtube_link'],
            'photo' => $validated['photo'],
        ]);

        $skillIds = collect($validated['skillItem'])->map(function ($skillName) {
            return Skill::firstOrCreate(['name' => $skillName])->id;
        })->all();
        $formation->skills()->sync($skillIds);

        return redirect()->route('admin.formations')->with('success', 'Formation mise à jour avec succès.');
    }

    public function activateFormation(Formation $formation)
    {
        $formation->update(['is_active' => true]);
        return redirect()->route('admin.formations')->with('success', 'Formation activée avec succès.');
    }

    public function deactivateFormation(Formation $formation)
    {
        $formation->update(['is_active' => false]);
        return redirect()->route('admin.formations')->with('success', 'Formation désactivée avec succès.');
    }

    // Sessions
    public function sessions(Request $request)
    {
        $sessions = Session::query()
            ->when($request->start_date, fn($query) => $query->whereDate('start_date', '>=', $request->start_date))
            ->when($request->end_date, fn($query) => $query->whereDate('end_date', '<=', $request->end_date))
            ->when($request->formation_id, fn($query) => $query->where('formation_id', $request->formation_id))
            ->with('formation', 'trainers')
            ->paginate(7);

        // Récupérer toutes les formations pour le filtre
        $formations = Formation::orderBy('name', 'asc')->get();

        return view('admin.sessions.index', compact('sessions', 'formations'));
    }

    public function createSession()
    {
        $formations = Formation::orderBy('name', 'asc')->get();
        $trainers = Trainer::orderBy('first_name', 'asc')->get();
        return view('admin.sessions.create', compact('formations', 'trainers'));
    }

    public function storeSession(Request $request)
    {
        $validated = $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'trainers' => 'required|array',
            'trainers.*' => 'exists:trainers,id',
            'start_date' => 'required|date|after_or_equal:' . Carbon::today()->format('Y-m-d'),
            'end_date' => 'required|date|after_or_equal:start_date',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'type' => 'required|in:Présentiel,Hybride,Distance',
            'price' => 'required|numeric|min:0',
        ]);

        $session = Session::create(array_merge($validated, ['status' => 'en attente']));
        $session->trainers()->sync($request->input('trainers', []));

        return redirect()->route('admin.sessions.index')->with('success', 'Session créée avec succès.');
    }

    public function edit(Session $session)
    {
        $formations = Formation::all();
        $trainers = Trainer::all();
        return view('admin.sessions.edit', compact('session', 'formations', 'trainers'));
    }

    public function update(Request $request, Session $session)
    {
        $rules = [
            'formation_id' => 'required|exists:formations,id',
            'trainers' => 'required|array',
            'trainers.*' => 'exists:trainers,id',
            'end_date' => 'required|date|after_or_equal:' . Carbon::today()->format('Y-m-d'),
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'type' => 'required|in:Présentiel,Hybride,Distance',
            'price' => 'required|numeric|min:0',
        ];

        if ($session->status != 'en cours') {
            $rules['start_date'] = 'required|date|after_or_equal:' . Carbon::today()->format('Y-m-d');
        }

        $validated = $request->validate($rules);

        unset($validated['status']);

        $session->update($validated);
        $session->trainers()->sync($request->input('trainers', []));

        return redirect()->route('admin.sessions.index')->with('success', 'Session mise à jour avec succès.');
    }

    public function deactivateSession(Session $session)
    {
        $session->update(['status' => 'annulée']);
        return redirect()->route('admin.sessions.index')->with('success', 'Session annulée avec succès.');
    }

    // Trainers
    public function trainers()
    {
        $trainers = Trainer::orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();
        return view('admin.trainers.index', compact('trainers'));
    }

    public function createTrainer()
    {
        return view('admin.trainers.create');
    }

    public function storeTrainer(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email',
            'phone' => 'required|string|max:255|unique:trainers,phone',
        ]);

        Trainer::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.trainers')->with('success', 'Formateur créé avec succès.');
    }

    public function showTrainer(Trainer $trainer)
    {
        $trainer->load('sessions');
        return view('admin.trainers.show', compact('trainer'));
    }

    public function editTrainer(Trainer $trainer)
    {
        return view('admin.trainers.edit', compact('trainer'));
    }

    public function updateTrainer(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email,' . $trainer->id,
            'phone' => 'required|string|max:255|unique:trainers,phone,' . $trainer->id,
        ]);

        $trainer->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('admin.trainers')->with('success', 'Formateur mis à jour avec succès.');
    }

    public function deactivateTrainer(Trainer $trainer)
    {
        $trainer->update(['is_active' => false]);
        return redirect()->route('admin.trainers')->with('success', 'Formateur désactivé avec succès.');
    }

    // Orders
    public function orders()
    {
        $orders = Order::with(['details', 'payment'])->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Payments
    public function payments()
    {
        $payments = Payment::with(['order.orderDetails.formation', 'order.orderDetails.session'])->get();
        $formations = Formation::all();
        $sessions = Session::with('formation')->get();
        return view('admin.payments.index', compact('payments', 'formations', 'sessions'));
    }

    public function exportPayments(Request $request)
    {
        $format = $request->query('format', 'xlsx');
        $formation = $request->query('formation', 'all');
        $session = $request->query('session', 'all');
        $status = $request->query('status', 'all');

        $query = Payment::with(['order.orderDetails.formation', 'order.orderDetails.session']);

        if ($formation !== 'all') {
            $query->whereHas('order.orderDetails.formation', function ($q) use ($formation) {
                $q->where('name', $formation);
            });
        }

        if ($session !== 'all') {
            $query->whereHas('order.orderDetails.session', function ($q) use ($session) {
                $q->whereRaw("CONCAT(DATE_FORMAT(start_date, '%d %M %Y'), ' - ', DATE_FORMAT(end_date, '%d %M %Y')) = ?", [$session]);
            });
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $payments = $query->get();

        $exportData = $payments->map(function ($payment) {
            return [
                'Participant' => $payment->order->first_name . ' ' . $payment->order->last_name,
                'Date' => \Carbon\Carbon::parse($payment->created_at)->locale('fr')->translatedFormat('d F Y H:i'),
                'Formation' => $payment->order->orderDetails->first()->formation->name,
                'Session' => \Carbon\Carbon::parse($payment->order->orderDetails->first()->session->start_date)->locale('fr')->translatedFormat('j F Y') . ' - ' . \Carbon\Carbon::parse($payment->order->orderDetails->first()->session->end_date)->locale('fr')->translatedFormat('j F Y'),
                'Statut de paiement' => $payment->status === 'completed' ? 'Payé' : ($payment->status === 'pending' ? 'En attente' : 'Échoué'),
                'Méthode de paiement' => $payment->payment_method ? ($payment->payment_method . ' •••• ' . substr($payment->payment_method, -4)) : 'N/A',
                'Montant' => number_format($payment->amount, 0, ',', ' ') . ' €',
            ];
        })->toArray();

        if ($format === 'xlsx') {
            return Excel::download(new class($exportData) implements FromArray, WithColumnFormatting {
                private $data;

                public function __construct($data)
                {
                    $this->data = $data;
                }

                public function array(): array
                {
                    return array_merge([array_keys($this->data[0] ?? [
                        'Participant', 'Date', 'Formation', 'Session', 'Statut de paiement', 'Méthode de paiement', 'Montant'
                    ])], $this->data);
                }

                public function columnFormats(): array
                {
                    return [
                        'B' => NumberFormat::FORMAT_TEXT,
                        'D' => NumberFormat::FORMAT_TEXT,
                        'F' => NumberFormat::FORMAT_TEXT,
                    ];
                }
            }, 'payments_' . now()->format('Ymd_His') . '.xlsx');
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.payments.payments_pdf', compact('payments'));
            return $pdf->download('payments_' . now()->format('Ymd_His') . '.pdf');
        }

        return redirect()->back()->with('error', 'Format d\'exportation non supporté.');
    }

    // Attendees
    public function attendees(Session $session)
    {
        $session->load(['orderDetails.order', 'orderDetails.formation']);
        $attendees = $session->orderDetails->map(function ($orderDetail) {
            $order = $orderDetail->order;
            return [
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'email' => $order->email,
                'phone' => $order->phone ?? 'N/A',
                'country' => $order->country ?? 'N/A',
                'company' => $order->company ?? 'N/A',
                'formation' => $orderDetail->formation->name,
                'session' => $orderDetail->session->start_date->format('F Y'),
                'session_start' => $orderDetail->session->start_date ? $orderDetail->session->start_date->toDateString() : null,
                'session_end' => $orderDetail->session->end_date ? $orderDetail->session->end_date->toDateString() : null,
                'total_price' => number_format($order->total_price, 0, ',', ' ') . ' €',
            ];
        });

        $filters = [
            'first_names' => $attendees->pluck('first_name')->unique()->sort()->values(),
            'last_names' => $attendees->pluck('last_name')->unique()->sort()->values(),
            'emails' => $attendees->pluck('email')->unique()->sort()->values(),
            'phones' => $attendees->pluck('phone')->unique()->sort()->values()->filter(),
            'countries' => $attendees->pluck('country')->unique()->sort()->values()->filter(),
            'companies' => $attendees->pluck('company')->unique()->sort()->values()->filter(),
            'formations' => $attendees->pluck('formation')->unique()->sort()->values(),
            'sessions' => $attendees->pluck('session')->unique()->sort()->values(),
        ];

        return view('admin.sessions.attendees', compact('session', 'attendees', 'filters'));
    }

    public function exportAttendees(Session $session, Request $request)
    {
        $format = $request->query('format', 'xlsx');
        $session->load(['orderDetails.order', 'orderDetails.formation']);
        $attendees = $session->orderDetails->map(function ($orderDetail) {
            $order = $orderDetail->order;
            return [
                'Prénom' => $order->first_name,
                'Nom' => $order->last_name,
                'Email' => $order->email,
                // Forcer le champ téléphone à être une chaîne (préfixe apostrophe)
                'Téléphone' => $order->phone ? (" " . (string)$order->phone) : 'N/A',
                'Pays' => $order->country ?? 'N/A',
                'Entreprise' => $order->company ?? 'N/A',
                'Formation' => $orderDetail->formation->name,
                'Session' => $orderDetail->session->start_date->format('F Y'),
                'Prix total' => number_format($order->total_price, 0, ',', ' ') . ' €',
            ];
        })->toArray();

        $start = $session->start_date ? $session->start_date->format('Ymd') : 'debut';
        $end = $session->end_date ? $session->end_date->format('Ymd') : 'fin';
        $filename = 'attendees_session_' . $start . '_' . $end;

        if ($format === 'xlsx') {
            return Excel::download(new class($attendees) implements FromArray, WithColumnFormatting {
                private $attendees;

                public function __construct($attendees)
                {
                    $this->attendees = $attendees;
                }

                public function array(): array
                {
                    return array_merge([array_keys($this->attendees[0] ?? ['Prénom', 'Nom', 'Email', 'Téléphone', 'Pays', 'Entreprise', 'Formation', 'Session', 'Prix total'])], $this->attendees);
                }

                public function columnFormats(): array
                {
                    return [
                        'D' => NumberFormat::FORMAT_TEXT, // Colonne Téléphone (4e colonne, D dans Excel)
                    ];
                }
            }, $filename . '.xlsx');
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.sessions.attendees_pdf', compact('attendees', 'session'));
            return $pdf->download($filename . '.pdf');
        }

        return redirect()->back()->with('error', 'Format d\'exportation non supporté.');
    }
}
