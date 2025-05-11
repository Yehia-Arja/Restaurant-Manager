import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:mobile/features/auth/data/models/user_model.dart';

class AuthRemote {
  final Dio _dio;
  AuthRemote(this._dio);

  // General method to handle both login and signup requests
  Future<UserModel> _authenticate(String endpoint, Map<String, dynamic> payload) async {
    try {
      final response = await _dio.post(endpoint, data: payload);

      final data = response.data['data'] as Map<String, dynamic>;
      final token = data['access_token'] as String;

      // Persist token once
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('token', token);

      // Return parsed user model
      return UserModel.fromJson(data['user'] as Map<String, dynamic>);
    } on DioException catch (error) {
      // Extract error message and rethrow
      final message =
          (error.response?.data['message'] as String?) ?? error.message ?? 'Unknown error';
      throw Exception(message);
    }
  }

  // Calls login endpoint
  Future<UserModel> login(String email, String password) {
    return _authenticate('guest/login', {'email': email, 'password': password});
  }

  // Calls signup endpoint
  Future<UserModel> signup(
    String name,
    String lastName,
    String email,
    String password,
    String confirmPassword,
  ) {
    return _authenticate('guest/signup', {
      'first_name': name,
      'last_name': lastName,
      'email': email,
      'password': password,
      'password_confirmation': confirmPassword,
    });
  }
}
