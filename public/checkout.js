// This is your test secret API key.
const stripe = Stripe("pk_test_51QrrBG4MkqdKTMhEyW1yGDUdNCcvNjoijFgK23X164oPHHdEVNYwpXbDtHoAZV0SZJrJ19vQGypkfnFsL0s2xCkX00bD2g4UYl");

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