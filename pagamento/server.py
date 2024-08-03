from flask import Flask, render_template, request, jsonify
from api import gerar_link_pagamento
app = Flask(__name__)

@app.route('/', methods=['POST'])
def process():
    data = request.get_json()
    link=gerar_link_pagamento(data)
    print(data)
    return render_template("invoice.html",data=data, link_pagamento=link)
@app.route('/success')
def success():
    return render_template("success.html")

if __name__ == "__main__":
    app.run(port=5000)
    