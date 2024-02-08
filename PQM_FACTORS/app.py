from flask import Flask, render_template, request, redirect
import numpy as np
import pandas as pd
import pickle

app = Flask(__name__)

# Initialize patient queue
user_queue = None

# Load the trained model
loaded_model = 'retrained_decision_tree_model.pkl'


class PatientQueue:
    def __init__(self, model_file):
        self.queue = []
        self.model = self.load_model(model_file)

    def load_model(self, model_file):
        try:
            with open(model_file, 'rb') as f:
                model = pickle.load(f)
            return model
        except FileNotFoundError:
            print("Error: Model file not found.")
            return None
        except Exception as e:
            print(f"Error loading model: {e}")
            return None

    def insert(self, patient_features):
        if self.model is None:
            print("Error: Model not loaded.")
            return

        try:
            # Convert patient features to a NumPy array with consistent data types
            patient_features = np.array(patient_features, dtype=np.float64).reshape(1, -1)

            print("Patient features:", patient_features)

            if hasattr(self.model, 'predict'):
                predicted_class = self.model.predict(patient_features)
                seriousness_level = predicted_class[0]
                print("Seriousness level:", seriousness_level)

                # Convert seriousness_level to the expected data type if needed
                seriousness_level = str(seriousness_level)

                self.queue.append((seriousness_level, patient_features))
                self.queue.sort(key=lambda x: x[0], reverse=True)
            else:
                print("Error: Model does not have 'predict' attribute.")
        except Exception as e:
            print(f"Error inserting patient: {e}")


    def pop(self):
        if not self.queue:
            print("Queue is empty.")
            return None
        print("Before pop, queue contents:", self.queue)
        patient_info= self.queue.pop(0)[1]
        print("After pop, queue contents:", self.queue)
        return patient_info


@app.route('/', methods=['GET', 'POST'])
def index():
    global user_queue
    if request.method == 'POST':
        # Collect patient information
        diastolic_bp = float(request.form['diastolic_bp'])
        systolic_bp = float(request.form['systolic_bp'])
        blood_sugar = float(request.form['blood_sugar'])
        oxygen_level = float(request.form['oxygen_level'])
        heart_rate = float(request.form['heart_rate'])
        body_temp = float(request.form['body_temp'])
        breath_rate = float(request.form['breath_rate'])
        urinalysis_ph = float(request.form['urinalysis_ph'])
        peak_flow = float(request.form['peak_flow'])
        hydration_level = float(request.form['hydration_level'])

        # Create patient feature vector
        patient_features = [diastolic_bp, systolic_bp, blood_sugar, oxygen_level,
                            heart_rate, body_temp, breath_rate, urinalysis_ph,
                            peak_flow, hydration_level]

        # Insert patient into the priority queue
        user_queue.insert(patient_features)

        return redirect('/')
    else:
        return render_template('index.html')


if __name__ == '__main__':
    user_queue = PatientQueue(loaded_model)
    app.run(debug=True)
