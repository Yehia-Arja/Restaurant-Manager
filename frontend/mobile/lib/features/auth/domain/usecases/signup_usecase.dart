import '../entities/user.dart';
import '../repositories/auth_repository.dart';

class SignupUsecase {
  final AuthRepository _repo;
  SignupUsecase(this._repo);

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
