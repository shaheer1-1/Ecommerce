(() => {
  const root = document.getElementById('payment-methods-root');
  if (!root) return;

  const stripe = Stripe(root.dataset.stripeKey);
  const card = stripe.elements().create('card', { hidePostalCode: true });
  card.mount('#pm-card-element');
  const errorsEl = document.getElementById('pm-card-errors');
  const btn = document.getElementById('pm-save-btn');
  card.on('change', e => errorsEl && (errorsEl.textContent = e.error?.message ?? ''));
  btn?.addEventListener('click', async () => {
    btn.disabled = true;
    errorsEl && (errorsEl.textContent = '');
    try {
      const { error, paymentMethod } = await stripe.createPaymentMethod({
        type: 'card',
        card,
        billing_details: { name: document.getElementById('pm_cardholder_name')?.value || '' },
      });
      if (error) throw new Error(error.message);
      await fetch(root.dataset.storeUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': root.dataset.csrf,
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          stripe_payment_method_id: paymentMethod.id,
          cardholder_name: document.getElementById('pm_cardholder_name')?.value || null,
          make_primary: document.getElementById('pm_make_primary')?.checked ?? false,
        }),
      }).then(r => r.ok ? r.json() : r.json().then(e => Promise.reject(e)));

      location.reload();
    } catch (e) {
      errorsEl && (errorsEl.textContent = e.message || 'Could not save card.');
      btn.disabled = false;
    }
  });
  document.querySelectorAll('.js-pm-make-primary, .js-pm-delete').forEach(el => {
    el.addEventListener('click', async () => {
      const isDelete = el.classList.contains('js-pm-delete');
      if (isDelete && !confirm('Delete this card?')) return;

      try {
        await fetch(el.dataset.url, {
          method: isDelete ? 'DELETE' : 'PATCH',
          credentials: 'same-origin',
          headers: { 'X-CSRF-TOKEN': root.dataset.csrf, 'Accept': 'application/json' },
        });
        location.reload();
      } catch (e) {
        alert(e.message || 'Something went wrong.');
      }
    });
  });
})();