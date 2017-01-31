<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['email_must_be_array'] = 'El método de validación del correo electrónico debería ser enviado como un Array.';
$lang['email_invalid_address'] = 'La siguiente direcciónd e correo es errónea: %s';
$lang['email_attachment_missing'] = 'Me ha sido imposible localizar el siguiente archivo adjunto: %s';
$lang['email_attachment_unreadable'] = 'Me ha sido imposible abrir el siguiente archivo adjunto: %s';
$lang['email_no_from'] = 'Me ha sido imposible enviar el mensaje de correo ya que no contiene remitente.';
$lang['email_no_recipients'] = 'Deberías de indicar los destinatarios: To, Cc, or Bcc';
$lang['email_send_failure_phpmail'] = 'Me ha sido imposible enviar el mensaje de correo mediante la función PHP mail(). Es posible que tu servidor no esté configurado adecuadamente.';
$lang['email_send_failure_sendmail'] = 'Me ha sido imposible enviar el mensaje de correo mediante la función PHP Sendmail. Tu servidor puede no estar adecuadamente configurado para el envío de mensajes por medio de este método.';
$lang['email_send_failure_smtp'] = 'Me ha sido imposible enviar el mensaje de correo mediante PHP SMTP. Revisa la configuración de tu servidor.';
$lang['email_sent'] = 'Tu mensaje ha sido enviado correctamente utilizando el protocolo: %s';
$lang['email_no_socket'] = 'Me ha sido imposible abrir un socket a Sendmail. Por favor, revisa tu configuración.';
$lang['email_no_hostname'] = 'PArece que no has configurado tu protocolo SMTP en el hostname.';
$lang['email_smtp_error'] = 'Se ha producido el siguiente error en tu SMTP: %s';
$lang['email_no_smtp_unpw'] = 'Error: Deberías de asignar un username y password en tu protocolo SMTP.';
$lang['email_failed_smtp_login'] = 'Error al enviar el comando de autenticación de usuario. Error: %s';
$lang['email_smtp_auth_un'] = 'Error al autenticar to usuario. Error: %s';
$lang['email_smtp_auth_pw'] = 'Error al autenticar tu contraseña. Error: %s';
$lang['email_smtp_data_failure'] = 'Error al enviar los datos : %s';
$lang['email_exit_status'] = 'Código de estado de envío: %s';
