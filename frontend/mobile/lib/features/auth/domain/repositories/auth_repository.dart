import 'package:mobile/features/auth/domain/entities/user.dart';

abstract class AuthRepository {
  Future<User> login({required String email, required String password});
  Future<User> signup({
    required String firstName,
    required String lastName,
    required String email,
    required String password,
    required String confirmPassword,
  });
}
