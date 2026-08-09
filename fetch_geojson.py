import urllib.request, json
url = 'https://nominatim.openstreetmap.org/search?q=Padepokan+Seni+Mangun+Dharma&format=json'
req = urllib.request.Request(url, headers={'User-Agent': 'Antigravity/1.0'})
try:
    with urllib.request.urlopen(req) as response:
        res = json.loads(response.read().decode())
        if res:
            print(f"Found: {res[0]['display_name']}")
        else:
            print('No candidates found')
except Exception as e:
    print(f'Error: {e}')
