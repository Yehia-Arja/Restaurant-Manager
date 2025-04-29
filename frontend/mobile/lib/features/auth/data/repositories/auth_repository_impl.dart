import 'package:mobile/features/auth/domain/entities/user.dart';
import 'package:mobile/features/auth/domain/repositories/auth_repository.dart';
import 'package:mobile/features/auth/data/models/user_model.dart';
import 'package:mobile/features/auth/data/datasources/auth_remote.dart';

class AuthRepositoryImpl implements AuthRepository {
    final AuthRemote _remote;
    AuthRepositoryImpl(this._remote);

    @override
    Future<User> login({required String email, required String password}) async {
        final userModel = await _remote.login(email, password);
        return User(
            id: userModel.id,
            name: userModel.name,
            email: userModel.email,
            dateOfBirth: userModel.dateOfBirth,
            phoneNumber: userModel.phoneNumber,
        );
    }
}
