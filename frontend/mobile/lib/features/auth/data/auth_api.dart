import 'package:shared_preferences/shared_preferences.dart';
import 'package:mobile/core/services/dio_service.dart';

class AuthAPI {
    static Future<void> login({
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

            if (response.statusCode != 200) {
                throw Exception('Failed to login: ${response.statusCode}');
            }

            if (response.data == null) {
                throw Exception('No data received from server');
            }

            final data = response.data;
            final token = data['access_token'];

            final prefs = await SharedPreferences.getInstance();
            await prefs.setString('token', token);

            return;

        } catch (e) {
            print('Login error: $e');
            rethrow;
        }
    }
}
