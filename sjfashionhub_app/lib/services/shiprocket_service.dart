import 'dart:convert';
import 'package:http/http.dart' as http;

class ShiprocketService {
  static const _loginUrl = 'https://apiv2.shiprocket.in/v1/external/auth/login';
  static const _trackUrlBase =
      'https://apiv2.shiprocket.in/v1/external/courier/track/awb/';
  static const email = 'YOUR_EMAIL';
  static const pwd = 'YOUR_PASSWORD';
  static String? _token;

  static Future<void> _auth() async {
    final r = await http.post(
      Uri.parse(_loginUrl),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({'email': email, 'password': pwd}),
    );
    if (r.statusCode == 200) {
      _token = jsonDecode(r.body)['token'];
    } else {
      throw Exception('Shiprocket auth');
    }
  }

  static Future<Map<String, dynamic>> track(String awb) async {
    if (_token == null) {
      await _auth();
    }
    final r = await http.get(
      Uri.parse('$_trackUrlBase$awb'),
      headers: {'Authorization': 'Bearer $_token'},
    );
    if (r.statusCode == 200) {
      return jsonDecode(r.body);
    } else {
      throw Exception('Track fail');
    }
  }
}
