const checkoutEl = document.getElementById('checkout');
const stripeKey = checkoutEl.dataset.stripeKey;

const stripe = Stripe(stripeKey);
const card = stripe.elements().create('card', {
    hidePostalCode: true
});
const form = document.getElementById('checkout-form');
const cardEl = document.getElementById('card-errors');
const pmInput = document.getElementById('stripe_payment_method_id');
const savedPmInput = document.getElementById('saved_payment_method_id');
const btn = document.getElementById('place-order-btn');
const wrap = document.getElementById('stripe-card-wrap');
const newCardWrap = document.getElementById('new-card-wrap');
const savedCardsWrap = document.getElementById('saved-cards-wrap');
const cardSourceEls = document.querySelectorAll('input[name="card_source"]');
const savedPmRadios = document.querySelectorAll('input[name="saved_payment_method_id"]');
function syncSavedCardRowHighlight() {
    document.querySelectorAll('[data-saved-card-label]').forEach(label => {
        const input = label.querySelector('input[name="saved_payment_method_id"]');
        label.classList.toggle('is-selected', !!(input && input.checked));
    });
}
const saveCardCb = document.getElementById('save_card');
const makePrimaryCb = document.getElementById('make_primary');
card.mount('#card-element');
card.on('change', e => {
    cardEl.textContent = e.error ? e.error.message : '';
});
document.querySelectorAll('input[name="payment_method"]').forEach(r =>
    r.addEventListener('change', () => {
        wrap.style.display = r.value === 'card' && r.checked ? '' : 'none';
        updateCardSourceUI();
    })
);
wrap.style.display =
    document.querySelector('input[name="payment_method"]:checked')?.value === 'card'
        ? '' : 'none';
function selectedCardSource() {
    return document.querySelector('input[name="card_source"]:checked')?.value || 'new';
}
function updateCardSourceUI() {
    const isCard = document.querySelector('input[name="payment_method"]:checked')?.value === 'card';
    if (!isCard) return;
    const src = selectedCardSource();
    if (newCardWrap) newCardWrap.style.display = src === 'new' ? '' : 'none';
    if (savedCardsWrap) savedCardsWrap.style.display = src === 'saved' ? '' : 'none';
    savedPmRadios.forEach(r => (r.disabled = src !== 'saved'));
    if (savedPmInput) savedPmInput.disabled = src !== 'new';
    if (saveCardCb) saveCardCb.disabled = src !== 'new';
    if (makePrimaryCb) makePrimaryCb.disabled = src !== 'new';
    if (src === 'saved') {
        pmInput.value = '';
        if (savedPmInput) savedPmInput.value = '';
        cardEl.textContent = '';
        const anyChecked = Array.from(savedPmRadios).some(r => r.checked);
        if (!anyChecked) {
            const firstEnabled = Array.from(savedPmRadios).find(r => !r.disabled);
            if (firstEnabled) firstEnabled.checked = true;
        }
        syncSavedCardRowHighlight();
    }
}
cardSourceEls.forEach(r => r.addEventListener('change', updateCardSourceUI));
savedPmRadios.forEach(r => r.addEventListener('change', syncSavedCardRowHighlight));
updateCardSourceUI();
syncSavedCardRowHighlight();
form.addEventListener('submit', async e => {
    if (document.querySelector('input[name="payment_method"]:checked')?.value !== 'card') return;
    if (selectedCardSource() === 'saved') {
        pmInput.value = '';
        if (savedPmInput) savedPmInput.value = '';
        return;
    }
    e.preventDefault();
    btn.disabled = true;
    const { error, paymentMethod } = await stripe.createPaymentMethod({
        type: 'card',
        card
    });
    if (error) {
        cardEl.textContent = error.message;
        btn.disabled = false;
        return;
    }
    try {
        const saveUrl = checkoutEl.dataset.saveCardUrl;
        const csrf = checkoutEl.dataset.csrf;
        if (!saveUrl || !csrf) throw new Error('Missing save-card endpoint configuration.');
        const resp = await fetch(saveUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                stripe_payment_method_id: paymentMethod.id,
                cardholder_name: document.getElementById('name')?.value || null,
                make_primary: !!(makePrimaryCb?.checked),
            }),
        });
        const payload = await resp.json().catch(() => ({}));
        if (!resp.ok) {
            const msg =
                payload?.message ||
                (payload?.errors ? Object.values(payload.errors).flat().join(' ') : null) ||
                'Could not save card.';
            throw new Error(msg);
        }
        if (savedPmInput) savedPmInput.value = payload.id || '';
        pmInput.value = '';
        form.submit();
    } catch (e2) {
        cardEl.textContent = e2?.message || 'Could not save card.';
        pmInput.value = paymentMethod.id;
        if (savedPmInput) savedPmInput.value = '';
        btn.disabled = false;
    }
});