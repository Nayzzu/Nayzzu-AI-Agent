import asyncio
import json
import datetime
from aiohttp import web

FILE_PERANGKAT = "status_perangkat.json"
FILE_LINGKUNGAN = "status_lingkungan.json"

# State global di memori
devices_data = {
    "lampu": "off",
    "tv": "off",
    "kulkas": "off",
    "ac": "off",
    "mesin_cuci": "off",
    "radio": "off"
}

lingkungan_data = {
    "suhu": 0.0,
    "kelembapan": 0.0,
    "jarak": 0.0
}

def save_json(filename, data):
    try:
        with open(filename, "w") as f:
            json.dump(data, f, indent=2)
    except Exception as e:
        print(f"[ERROR] Gagal simpan {filename}: {e}")

# --- 1. ENDPOINT STATUS PERANGKAT (6 LED) ---

async def handle_get_perangkat(request):
    return web.json_response(devices_data, headers={"Access-Control-Allow-Origin": "*"})

async def handle_post_perangkat(request):
    headers = {"Access-Control-Allow-Origin": "*", "Access-Control-Allow-Headers": "Content-Type"}
    try:
        data = await request.json()
        
        # Update sakelar tunggal { "device": "lampu", "state": true }
        if "device" in data:
            dev = str(data["device"]).lower().strip()
            state_val = data["state"]
            is_on = (state_val is True or str(state_val).lower() in ["on", "1"])
            devices_data[dev] = "on" if is_on else "off"
            
        # Update banyak sakelar sekaligus { "devices": { "lampu": "on", "tv": "off" } }
        if "devices" in data and isinstance(data["devices"], dict):
            for dev, val in data["devices"].items():
                is_on = (val is True or str(val).lower() in ["on", "1"])
                devices_data[dev.lower().strip()] = "on" if is_on else "off"

        save_json(FILE_PERANGKAT, devices_data)
        return web.json_response(devices_data, headers=headers)
    except Exception as e:
        return web.json_response({"error": str(e)}, status=400, headers=headers)

# --- 2. ENDPOINT STATUS LINGKUNGAN (TELEMETRI SENSOR) ---

async def handle_get_lingkungan(request):
    return web.json_response(lingkungan_data, headers={"Access-Control-Allow-Origin": "*"})

async def handle_post_lingkungan(request):
    headers = {"Access-Control-Allow-Origin": "*", "Access-Control-Allow-Headers": "Content-Type"}
    try:
        data = await request.json()
        
        # Format langsung { "suhu": 28.5, "kelembapan": 65, "jarak": 12 }
        # atau terbungkus { "telemetry": { ... } }
        t = data.get("telemetry", data)
        
        if "suhu" in t: lingkungan_data["suhu"] = float(t["suhu"])
        if "kelembapan" in t: lingkungan_data["kelembapan"] = float(t["kelembapan"])
        if "jarak" in t: lingkungan_data["jarak"] = float(t["jarak"])

        save_json(FILE_LINGKUNGAN, lingkungan_data)
        return web.json_response(lingkungan_data, headers=headers)
    except Exception as e:
        return web.json_response({"error": str(e)}, status=400, headers=headers)

# --- CORS PREFLIGHT OPTION ---

async def handle_options(request):
    headers = {
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Methods": "GET, POST, OPTIONS",
        "Access-Control-Allow-Headers": "Content-Type"
    }
    return web.Response(status=200, headers=headers)

# --- MAIN SERVER ---

async def main():
    save_json(FILE_PERANGKAT, devices_data)
    save_json(FILE_LINGKUNGAN, lingkungan_data)
    
    app = web.Application()
    
    # Route Perangkat
    app.router.add_get('/status_perangkat', handle_get_perangkat)
    app.router.add_post('/status_perangkat', handle_post_perangkat)
    app.router.add_options('/status_perangkat', handle_options)
    
    # Route Lingkungan
    app.router.add_get('/status_lingkungan', handle_get_lingkungan)
    app.router.add_post('/status_lingkungan', handle_post_lingkungan)
    app.router.add_options('/status_lingkungan', handle_options)
    
    runner = web.AppRunner(app)
    await runner.setup()
    site = web.TCPSite(runner, '0.0.0.0', 5000)
    await site.start()
    ""
    print("=" * 60)
    print(f"[{datetime.datetime.now().strftime('%H:%M:%S')}] SERVER IOT DUAL-ENDPOINT ONLINE!")
    print("-> API Sakelar LED  : http://localhost:5000/status_perangkat")
    print("-> API Telemetri    : http://localhost:5000/status_lingkungan")
    print("=" * 60)
    
    await asyncio.Event().wait()

if __name__ == "__main__":
    asyncio.run(main())