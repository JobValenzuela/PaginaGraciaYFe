export const responseMessages = {
    // 200
    ok: 'Operación exitosa',
    deleted: 'Elemento eliminado correctamente',
    created: 'Elemento creado correctamente',
  
    // 400
    invalid_json: 'JSON inválido',
    bad_request: 'Solicitud incorrecta',
    username_in_use: 'El nombre de usuario ya está en uso',
    email_in_use: 'El correo electrónico ya está en uso',
    wrong_user: 'Usuario no encontrado',
    without_funds: 'No cuentas con suficiente saldo para realizar esta compra',
    wrong_coupon_code: 'Código de cupón incorrecto',
    cabagna_in_maintenance: 'La cabaña está en mantenimiento',
    cabagna_in_reservation: 'La cabaña tiene reservaciones activas',
    membership_in_use: 'La membresía está en uso',
    verification_code_timeout: 'El código de verificación ha caducado',
  
    // 401
    invalid: 'Sesión inválida',
    no_auth: 'No autorizado',
    email_not_verified: 'Correo electrónico no verificado',
    wrong_verification_code: 'Código de verificación incorrecto',
    no_membership: 'No cuentas con una membresía',
    no_prepaid_membership: 'No cuentas con una membresía prepago'
  }

const ResponseHandler = {
    // 200
    ok: 'ok',
    deleted: 'deleted',
    created: 'created',

    // 400
    invalid_json: 'invalid_json',
    bad_request: 'bad_request',
    username_in_use: 'username_in_use',
    email_in_use: 'email_in_use',
    wrong_user: 'wrong_user',
    wrong_coupon_code: 'wrong_coupon_code',
    without_funds: 'without_founds',
    cabagna_in_maintenance: 'cabagna_in_maintenance',
    cabagna_in_reservation: 'cabagna_in_reservation',
    membership_in_use: 'membership_in_use',
    verification_code_timeout: 'verification_code_timeout',

    // 401
    invalid: 'invalid',
    no_auth: 'no_auth',
    email_not_verified: 'email_not_verified',
    wrong_verification_code: 'wrong_verification_code',
    no_membership: 'no_membership',
    no_prepaid_membership: 'no_prepaid_membership'
}

export default ResponseHandler
