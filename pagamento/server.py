from flask import Flask, render_template, request, jsonify
from api import gerar_link_pagamento
app = Flask(__name__)

@app.route('/', methods=['POST'])
def process():
    data = request.get_json()
    argumento = data.get('argumento')
    resultado = f"Resultado: {argumento}"
    link = gerar_link_pagamento()
    return render_template("homepage.php", link_pagamento=link)

    # return gerar_link_pagamento()
    # return jsonify({"resultado": resultado})
if __name__ == "__main__":
    app.run(port=5000)
    