// This is your test secret API key.
// const stripe = Stripe("pk_test_51QrrB5GD9MOU8zP2GxXVRQWnI8sYdp1P0ijui3zsoBPPmccSjiSyWMA3BthqAGfn07SFJA4ivJ6AJ45tB3cknfAA00OEt4TVxx");
// const stripe = Stripe("sk_test_51QrrB5GD9MOU8zP2kVhQOpa2GkB7z1pDTqgKFC7qeXorAbptHQ1JcKnf1eLQ53zKlDqV1GjhPX0Q7KsSsyhBYKAp00zLVoYeJZ");
const stripe = Stripe("sk_test_51QrrB5GD9MOU8zP2kVhQOpa2GkB7z1pDTqgKFC7qeXorAbptHQ1JcKnf1eLQ53zKlDqV1GjhPX0Q7KsSsyhBYKAp00zLVoYeJZ");

initialize();

// Create a Checkout Session
async function initialize() {
  const fetchClientSecret = async () => {
    const response = await fetch("checkout.php", {
      method: "POST",
    });
    const { clientSecret } = await response.json();
    return clientSecret;
  };

  const checkout = await stripe.initEmbeddedCheckout({
    fetchClientSecret,
  });

  // Mount Checkout
  checkout.mount('#checkout');
}