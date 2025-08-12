@extends('layouts.app')

@section('content')
    <!-- Contact Section -->
    <section class="contact-section" id="contact">
      <div class="container">
        <h2 class="fade-in parallax-slow">Contactez-nous</h2>
        <div class="contact-content fade-in parallax-medium">
          <div class="contact-info">
            <div class="contact-item">
              <i class="fas fa-envelope"></i>
              <div>
                <h4>Email</h4>
                <p>contact@yelsfinances.com</p>
              </div>
            </div>
            <div class="contact-item">
              <i class="fas fa-phone"></i>
              <div>
                <h4>Téléphone</h4>
                <p>+33 1 23 45 67 89</p>
              </div>
            </div>
            <div class="contact-item">
              <i class="fas fa-map-marker-alt"></i>
              <div>
                <h4>Adresse</h4>
                <p>123 Rue de la Formation, Paris</p>
              </div>
            </div>
            <div class="contact-item">
              <i class="fas fa-clock"></i>
              <div>
                <h4>Horaires d'ouverture</h4>
                <p>Lun-Ven: 9h-18h<br>Sam: 9h-12h</p>
              </div>
            </div>
          </div>
          <div class="contact-form">
            <h3>Envoyez-nous un message</h3>
            <form id="contactForm">
              <div class="form-group">
                <input type="text" name="name" placeholder="Votre nom" required>
              </div>
              <div class="form-group">
                <input type="email" name="email" placeholder="Votre email" required>
              </div>
              <div class="form-group">
                <input type="tel" name="phone" placeholder="Votre téléphone">
              </div>
              <div class="form-group">
                <select name="subject">
                  <option value="">Sujet de votre message</option>
                  <option value="formation">Demande de formation</option>
                  <option value="information">Demande d'information</option>
                  <option value="support">Support technique</option>
                  <option value="autre">Autre</option>
                </select>
              </div>
              <div class="form-group">
                <textarea name="message" placeholder="Votre message" rows="5" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Envoyer le message</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
      <div class="container">
        <h2 class="fade-in parallax-slow">Questions Fréquentes</h2>
        <div class="faq-content fade-in parallax-medium">
          <div class="faq-item">
            <div class="faq-question">
              <h3>Comment s'inscrire à une formation ?</h3>
              <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
              <p>Vous pouvez vous inscrire directement sur notre site en ajoutant la formation à votre panier et en finalisant votre commande. Vous recevrez ensuite un email de confirmation avec les détails de votre formation.</p>
            </div>
          </div>
          <div class="faq-item">
            <div class="faq-question">
              <h3>Les formations sont-elles en ligne ou en présentiel ?</h3>
              <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
              <p>Nous proposons les deux formats : des formations 100% en ligne et des formations hybrides (en ligne + sessions en présentiel). Vous pouvez choisir le format qui vous convient le mieux.</p>
            </div>
          </div>
          <div class="faq-item">
            <div class="faq-question">
              <h3>Quels sont les moyens de paiement acceptés ?</h3>
              <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
              <p>Nous acceptons les cartes bancaires (Visa, Mastercard), les virements bancaires et les paiements en plusieurs fois pour certaines formations.</p>
            </div>
          </div>
          <div class="faq-item">
            <div class="faq-question">
              <h3>Y a-t-il un certificat à la fin de la formation ?</h3>
              <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
              <p>Oui, tous nos participants reçoivent un certificat de formation reconnu à la fin de leur parcours, attestant de leurs compétences acquises.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection



