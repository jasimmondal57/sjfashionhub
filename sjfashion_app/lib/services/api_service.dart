import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import '../config/app_config.dart';

class ApiService {
  final GetStorage _storage = GetStorage();
  
  Map<String, String> get _headers {
    final headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    
    final token = _storage.read('auth_token');
    if (token != null) {
      headers['Authorization'] = 'Bearer $token';
    }
    
    return headers;
  }
  
  Future<Map<String, dynamic>> get(String endpoint) async {
    try {
      final url = Uri.parse('${AppConfig.apiUrl}$endpoint');
      print('GET: $url');
      
      final response = await http.get(url, headers: _headers);
      
      print('Response Status: ${response.statusCode}');
      print('Response Body: ${response.body}');
      
      return _handleResponse(response);
    } catch (e) {
      print('GET Error: $e');
      throw _handleError(e);
    }
  }
  
  Future<Map<String, dynamic>> post(String endpoint, Map<String, dynamic> data) async {
    try {
      final url = Uri.parse('${AppConfig.apiUrl}$endpoint');
      print('POST: $url');
      print('Data: $data');
      
      final response = await http.post(
        url,
        headers: _headers,
        body: jsonEncode(data),
      );
      
      print('Response Status: ${response.statusCode}');
      print('Response Body: ${response.body}');
      
      return _handleResponse(response);
    } catch (e) {
      print('POST Error: $e');
      throw _handleError(e);
    }
  }
  
  Future<Map<String, dynamic>> put(String endpoint, Map<String, dynamic> data) async {
    try {
      final url = Uri.parse('${AppConfig.apiUrl}$endpoint');
      print('PUT: $url');
      print('Data: $data');
      
      final response = await http.put(
        url,
        headers: _headers,
        body: jsonEncode(data),
      );
      
      print('Response Status: ${response.statusCode}');
      print('Response Body: ${response.body}');
      
      return _handleResponse(response);
    } catch (e) {
      print('PUT Error: $e');
      throw _handleError(e);
    }
  }
  
  Future<Map<String, dynamic>> delete(String endpoint) async {
    try {
      final url = Uri.parse('${AppConfig.apiUrl}$endpoint');
      print('DELETE: $url');
      
      final response = await http.delete(url, headers: _headers);
      
      print('Response Status: ${response.statusCode}');
      print('Response Body: ${response.body}');
      
      return _handleResponse(response);
    } catch (e) {
      print('DELETE Error: $e');
      throw _handleError(e);
    }
  }
  
  Map<String, dynamic> _handleResponse(http.Response response) {
    final statusCode = response.statusCode;
    
    if (statusCode >= 200 && statusCode < 300) {
      try {
        final data = jsonDecode(response.body);
        return data is Map<String, dynamic> ? data : {'data': data};
      } catch (e) {
        return {'success': true, 'data': response.body};
      }
    } else if (statusCode == 401) {
      // Unauthorized - clear auth data and redirect to login
      _storage.remove('auth_token');
      _storage.remove('user_data');
      Get.offAllNamed('/login');
      throw 'Session expired. Please login again.';
    } else {
      try {
        final errorData = jsonDecode(response.body);
        throw errorData['message'] ?? 'Request failed with status $statusCode';
      } catch (e) {
        throw 'Request failed with status $statusCode';
      }
    }
  }
  
  String _handleError(dynamic error) {
    if (error is String) {
      return error;
    } else {
      return 'Network error occurred. Please check your connection.';
    }
  }
}
