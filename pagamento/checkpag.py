import mercadopago
sdk = mercadopago.SDK("TEST-5706462506921008-050300-e63cf13226a57e8fefac981aec297674-540037296")

request = sdk.payment().get('540037296-7f2ad54a-2c20-4ff1-9297-ed5a4ad47ae2')
print(request)