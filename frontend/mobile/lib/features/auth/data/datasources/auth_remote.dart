import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:mobile/features/auth/data/models/user_model.dart';

class AuthRemote {
  final Dio _dio;

  // Construct with an injected Dio client for flexibility and testability
  AuthRemote(this._dio);

  // Calls the login endpoint, saves the token, and returns a UserModel
  Future<UserModel> login(String email, String password) async {
    try {
      final response = await _dio.post(
        'guest/login',
        data: {'email': email, 'password': password},
      );
      final data = response.data['data'] as Map<String, dynamic>;
      final token = data['access_token'] as String;

      // Persist token
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('token', token);

      // Return parsed user model
      return UserModel.fromJson(data['user'] as Map<String, dynamic>);
    } on DioException catch (error) {
      // Extract error message and rethrow as an exception
      final message =
          (error.response?.data['message'] as String?) ??
          error.message ??
          'An unknown error occurred';
      throw Exception(message);
    }
  }
}
