import '../entities/user.dart';
import '../repositories/auth_repository.dart';

class LoginUseCase {
  final AuthRepository _repo;
  LoginUseCase(this._repo);

  Future<User> call({required String email, required String password}) {
    return _repo.login(email: email, password: password);
  }
}
