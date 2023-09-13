from flask import Flask, jsonify, request
import psutil
import time
import subprocess
import json

app = Flask(__name__)

DEFAULT_INTERFACE = ""  # Ganti dengan nama antarmuka default yang sesuai
API_KEY = "YOUR_API_KEY"  # Ganti dengan API key yang sesuai


def add_cors_headers(response):
    response.headers['Access-Control-Allow-Origin'] = '*'
    response.headers['Access-Control-Allow-Headers'] = 'Content-Type'
    response.headers['Access-Control-Allow-Methods'] = 'GET, POST, OPTIONS'
    response.headers['Access-Control-Expose-Headers'] = 'Content-Type'
    return response

@app.route('/interfaces')
def get_interfaces():
    api_key = request.args.get('api_key', default="", type=str)

    if api_key != API_KEY:
        response = jsonify({"error": "Invalid API key."})
        return add_cors_headers(response)

    interfaces = psutil.net_if_stats()
    active_interfaces = [i for i, stat in interfaces.items() if stat.isup]
    response = jsonify(active_interfaces)
    return add_cors_headers(response)

@app.route('/bandwidth')
def bandwidth():
    interface = request.args.get('interface', default=DEFAULT_INTERFACE, type=str)
    api_key = request.args.get('api_key', default="", type=str)

    if api_key != API_KEY:
        response = jsonify({"error": "Invalid API key."})
        return add_cors_headers(response)

    try:
        if interface not in psutil.net_io_counters(pernic=True, nowrap=True):
            response = jsonify({"error": f"Interface '{interface}' not found or doesn't exist."})
            return add_cors_headers(response)

        net_stat_1 = psutil.net_io_counters(pernic=True, nowrap=True)[interface]
        net_in_1 = net_stat_1.bytes_recv
        net_out_1 = net_stat_1.bytes_sent
        time.sleep(1)
        net_stat_2 = psutil.net_io_counters(pernic=True, nowrap=True)[interface]
        net_in_2 = net_stat_2.bytes_recv
        net_out_2 = net_stat_2.bytes_sent

        net_in_mb = round((net_in_2 - net_in_1) / 1024 / 1024, 1)
        net_out_mb = round((net_out_2 - net_out_1) / 1024 / 1024, 1)

        net_in_mbps = round(net_in_mb * 8, 1)
        net_out_mbps = round(net_out_mb * 8, 1)

        result = {
            "received": net_in_mbps,
            "sent": net_out_mbps
        }

        response = jsonify(result)
        return add_cors_headers(response)

    except KeyError:
        response = jsonify({"error": f"Interface '{interface}' not found or doesn't exist."})
        return add_cors_headers(response)

@app.route('/ip_route', methods=['GET'])
def get_routes():
    api_key = request.args.get('api_key', default="", type=str)
    if api_key != API_KEY:
        response = jsonify({"error": "Invalid API key."})
        return add_cors_headers(response)

    try:
        command = 'vtysh -c "show ip route summary json"'
        output = subprocess.check_output(command, shell=True, text=True)

        routes_data = json.loads(output)

        response = jsonify(routes_data)
        return add_cors_headers(response), 200
    except subprocess.CalledProcessError as e:
        return f"Error executing command: {e}", 500

if __name__ == "__main__":
    app.run(debug=True, use_reloader=True, host='0.0.0.0', port=5000)