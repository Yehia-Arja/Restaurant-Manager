import '../entities/user.dart';
import '../repositories/auth_repository.dart';

class SignupUseCase {
  final AuthRepository _repo;
  SignupUseCase(this._repo);

  Future<User> call({
    required String firstName,
    required String lastName,
    required String email,
    required String password,
    required String confirmPassword,
  }) {
    return _repo.signup(
      firstName: firstName,
      lastName: lastName,
      email: email,
      password: password,
      confirmPassword: confirmPassword,
    );
  }
}
