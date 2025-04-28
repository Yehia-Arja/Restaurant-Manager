import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:mobile/core/services/dio_service.dart';
import '../models/login_response.dart';

class AuthAPI {
    // This class handles the API calls related to authentication.
    static Future<LoginResponse> login({
        required String email,
        required String password,
    }) async {
        try {
            final response = await DioService.dio.post(
                'guest/login',
                data: {'email': email, 'password': password},
            );
            final data    = response.data['data'] as Map<String, dynamic>;
            final message = response.data['message'] as String;

            final token = data['access_token'] as String;
            final prefs = await SharedPreferences.getInstance();
            await prefs.setString('token', token);

            final userJson = data['user'] as Map<String, dynamic>;
            return LoginResponse.fromJson({
                'success': true,
                'message': message,
                'user': userJson,
            });
        } on DioError catch (error) {

            final msg = (error.response?.data['message'] as String?)
                ?? error.message
                ?? 'An unknown error occurred';
            return LoginResponse(success: false, message: msg);

        } catch (_) {
            return LoginResponse(
                success: false,
                message: 'Could not connect to server. Please try again.',
            );
        }
    }
}
