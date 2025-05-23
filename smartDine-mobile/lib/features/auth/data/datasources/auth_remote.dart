import 'package:dio/dio.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:mobile/features/auth/data/models/user_model.dart';

class AuthRemote {
  final Dio _dio;
  final FlutterSecureStorage _secureStorage = const FlutterSecureStorage();

  AuthRemote(this._dio);

  Future<UserModel> _authenticate(String endpoint, Map<String, dynamic> payload) async {
    try {
      final response = await _dio.post(endpoint, data: payload);

      final data = response.data['data'] as Map<String, dynamic>;
      final token = data['access_token'] as String;

      await _secureStorage.write(key: 'access_token', value: token);

      return UserModel.fromJson(data['user'] as Map<String, dynamic>);
    } on DioException catch (error) {
      final message =
          (error.response?.data['message'] as String?) ?? error.message ?? 'Unknown error';
      throw Exception(message);
    }
  }

  Future<UserModel> login(String email, String password) {
    return _authenticate('guest/login', {'email': email, 'password': password});
  }

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
