import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:mobile/core/services/dio_service.dart';

class AuthAPI {
    static Future<Map<String, dynamic>> login({
        required String email,
        required String password,
    }) async {
        final response = await DioService.dio.post(
            'guest/login',
            data: {'email': email, 'password': password},
        );

        final data = response.data['data'];
        final token = data['access_token'] as String;

        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('token', token);

        // return just the user JSON and message
        return data['user',data.message] as Map<String, dynamic>;
    }

}