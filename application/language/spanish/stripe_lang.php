
<?php

/*
 * Spanish language
 */

// generic start

//HTTP status code summary
$lang['stripe_err_200'] = 'Todo ha funcionado tal y como estaba previsto';
$lang['stripe_err_400'] = 'Petición errónea. La petición no pudo ser aceptada. Por regla general es debido a que falta algún parámetro por introducir.';
$lang['stripe_err_401'] = 'No autorizada. La clave APIkey proporciona no es válida.';
$lang['stripe_err_402'] = 'Petición fallida. Los parámetros enviados eran válidos pero la petición falló.';
$lang['stripe_err_404'] = 'No encontrado. El recurso solicitado no pudo ser localizado.';
$lang['stripe_err_409'] = 'Conflicto. Existe un conflicto con otra petición realizada (quizás sea debido a que estás utilizando una clave errónea).';
$lang['stripe_err_429'] = 'Demasiadas peticiones. Demasiadas peticiones enviadas a la API al mismo tiempo ';
$lang['stripe_err_500'] = 'Demasiadas peticiones. Demasiadas peticiones enviadas a la API al mismo tiempo ';
$lang['stripe_err_502'] = 'Demasiadas peticiones. Demasiadas peticiones enviadas a la API al mismo tiempo ';
$lang['stripe_err_503'] = 'Demasiadas peticiones. Demasiadas peticiones enviadas a la API al mismo tiempo ';
$lang['stripe_err_504'] = 'Demasiadas peticiones. Demasiadas peticiones enviadas a la API al mismo tiempo ';

//TYPES
$lang['stripe_api_connection_error'] = 'Error al tratar de conectar con la API de Stripe.';
$lang['stripe_api_error'] = 'Los errores con la API suelen ser problemas muy poco habituales. ';
$lang['stripe_authentication_error'] = 'Error al tratar de autenticarte a tu mismo en la petición.';
$lang['stripe_card_error'] = 'Error al tratar de realizar el cargo en la tarjeta de crédito. Consulta tu entidad bancaria o inténtalo de nuevo mediante otra tarjeta.';
$lang['stripe_invalid_request_error'] = 'La petición ha devuelto un error debido a que alguno de los parámetros enviados es erróneo.';
$lang['stripe_rate_limit_error'] = 'Demasiadas peticiones enviadas de forma simultánea. ';

//CODES
$lang['stripe_invalid_number'] = 'El número de la tarjeta de crédito es erróneo';
$lang['stripe_invalid_expiry_month'] = 'La fecha de vencimiento de la tarjeta es erróneo';
$lang['stripe_invalid_expiry_year'] = 'El año de vencimiento de la tarjeta es erróneo';
$lang['stripe_invalid_cvc'] = 'El código se seguridad de la tarjeta de crédito es erróneo';
$lang['stripe_incorrect_number'] = 'El código de la tarjeta es erróneo';
$lang['stripe_expired_card'] = 'La tarjeta fué rechazada';
$lang['stripe_incorrect_cvc'] = 'El código de seguridad de la tarjeta de crédito es incorrecto';
$lang['stripe_incorrect_zip'] = 'El código de la tarjeta es erróneo';
$lang['stripe_card_declined'] = 'La tarjeta fué rechazada';
$lang['stripe_missing'] = 'No existe ninguna tarjeta a la que ser cargada';
$lang['stripe_processing_error'] = 'Se ha producido un error al intentar procesar la tarjeta';
