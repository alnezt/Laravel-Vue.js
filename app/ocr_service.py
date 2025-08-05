from flask import Flask, request, jsonify
from flask_cors import CORS
import easyocr
import cv2
import numpy as np

app = Flask(__name__)
CORS(app)

reader = easyocr.Reader(['ro', 'en'])

@app.route('/ocr', methods=['POST'])
def ocr():
    file = request.files['image']
    img = cv2.imdecode(np.frombuffer(file.read(), np.uint8), cv2.IMREAD_COLOR)
    results = reader.readtext(img)
    return jsonify({"text": [text for (_, text, _) in results]})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)
