import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:mobile/core/services/dio_service.dart';

class AuthAPI {
    // Calls POST /guest/login and always returns a Map with:
    // success: bool
    // message: String
    // user: Map<String, dynamic>?  (only when success is true)
    static Future<Map<String, dynamic>> login({
        required String email,
        required String password,
    }) async {
        try {
            final response = await DioService.dio.post(
                'guest/login',
                data: {
                    'email': email,
                    'password': password,
                },
            );

            final data    = response.data['data'] as Map<String, dynamic>;
            final message = response.data['message'] as String;

            // persist token
            final token = data['access_token'] as String;
            final prefs = await SharedPreferences.getInstance();
            await prefs.setString('token', token);

            // extract user JSON
            final userJson = data['user'] as Map<String, dynamic>;

            return {
                'success': true,
                'message': message,
                'user': userJson,
            };
        } on DioError catch (error) {
            // If the backend returned a response with an error message
            final msg = (error.response?.data['message'] as String?) 
                ?? error.message 
                ?? 'An unknown error occurred';
            return {
                'success': false,
                'message': msg,
            };
        } catch (error) {
            // Any other error (parsing, network down, etc.)
            return {
                'success': false,
                'message': 'Could not connect to server. Please try again.',
            };
        }
    }
}
