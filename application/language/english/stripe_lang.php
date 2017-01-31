
<?php

/*
 * English language
 */

// generic start
//HTTP status code summary
$lang['stripe_err_200'] = 'Everything worked as expected.';
$lang['stripe_err_400'] = 'The request was unacceptable, often due to missing a required parameter.';
$lang['stripe_err_401'] = 'No valid API key provided.';
$lang['stripe_err_402'] = 'The parameters were valid but the request failed.';
$lang['stripe_err_404'] = 'The requested resource does not exist.';
$lang['stripe_err_409'] = 'The request conflicts with another request (perhaps due to using the same idempotent key).';
$lang['stripe_err_429'] = 'Too many requests hit the API too quickly.';
$lang['stripe_err_500'] = 'Something went wrong on end of Stripe.';
$lang['stripe_err_502'] = 'Something went wrong on end of Stripe.';
$lang['stripe_err_503'] = 'Something went wrong on end of Stripe.';
$lang['stripe_err_504'] = 'Something went wrong on end of Stripe.';

//TYPES
$lang['stripe_api_connection_error'] = 'Failure to connect to API of Stripe.';
$lang['stripe_api_error'] = 'API errors cover any other type of problem (e.g., a temporary problem with servers of Stripe) and are extremely uncommon.';
$lang['stripe_authentication_error'] = 'Failure to properly authenticate yourself in the request.';
$lang['stripe_card_error'] = 'Card errors are the most common type of error you should expect to handle. They result when the user enters a card that cannot be charged for some reason.';
$lang['stripe_invalid_request_error'] = 'Invalid request errors arise when your request has invalid parameters.';
$lang['stripe_rate_limit_error'] = 'Too many requests hit the API too quickly.';
//CODES
$lang['stripe_invalid_number'] = 'The card number is not a valid credit card number.';
$lang['stripe_invalid_expiry_month'] = 'The expiration month of card is invalid.';
$lang['stripe_invalid_expiry_year'] = 'The expiration year of card is invalid.';
$lang['stripe_invalid_cvc'] = 'The security code of card is invalid.';
$lang['stripe_incorrect_number'] = 'The card number is incorrect.';
$lang['stripe_expired_card'] = 'The card has expired.';
$lang['stripe_incorrect_cvc'] = 'The security code of card is incorrect.';
$lang['stripe_incorrect_zip'] = 'The zip code  of card failed validation.';
$lang['stripe_card_declined'] = 'The card was declined.';
$lang['stripe_missing'] = 'There is no card on a customer that is being charged.';
$lang['stripe_processing_error'] = 'An error occurred while processing the card.';
