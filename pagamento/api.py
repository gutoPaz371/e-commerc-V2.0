import mercadopago
def gerar_link_pagamento(data):
    sdk = mercadopago.SDK("TEST-5706462506921008-050300-e63cf13226a57e8fefac981aec297674-540037296")

    payment_data = {
        #"external_reference": "1643827245",
        "items": data,
        "back_urls":{
            "success": "http://127.0.0.1:5000/success"
            
        },
        "auto_return": "approved"
    }
    result = sdk.preference().create(payment_data)
    payment = result["response"]
    print(payment)
    return payment['init_point']    