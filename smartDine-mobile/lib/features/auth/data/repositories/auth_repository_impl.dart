import 'package:mobile/features/auth/domain/entities/user.dart';
import 'package:mobile/features/auth/domain/repositories/auth_repository.dart';
import 'package:mobile/features/auth/data/datasources/auth_remote.dart';
import 'package:mobile/features/auth/data/models/user_model.dart';

class AuthRepositoryImpl implements AuthRepository {
  final AuthRemote _remote;
  AuthRepositoryImpl(this._remote);

  @override
  Future<User> login({required String email, required String password}) async {
    final userModel = await _remote.login(email, password);
    return _mapToEntity(userModel);
  }

  @override
  Future<User> signup({
    required String firstName,
    required String lastName,
    required String email,
    required String password,
    required String confirmPassword,
  }) async {
    final userModel = await _remote.signup(firstName, lastName, email, password, confirmPassword);
    return _mapToEntity(userModel);
  }

  User _mapToEntity(UserModel model) => User(
    firstName: model.firstName,
    lastName: model.lastName,
    email: model.email,
    userTypeId: model.userTypeId,
  );
}
