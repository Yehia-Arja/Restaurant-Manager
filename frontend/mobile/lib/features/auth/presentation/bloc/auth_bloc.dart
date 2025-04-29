import 'package:bloc/bloc.dart';
import '../../domain/usecases/login_usecase.dart';
import 'auth_event.dart';
import 'auth_state.dart';

class AuthBloc extends Bloc<AuthEvent, AuthState> {
    final LoginUseCase _loginUseCase;

    AuthBloc(this._loginUseCase) : super(AuthInitial()) {
        on<LoginRequested>((event, emit) async {
            if (event.email.isEmpty || event.password.isEmpty) {
                emit(AuthError("Email and password are both required."));
                return;
            }
            emit(AuthLoading());
            try {
                final user = await _loginUseCase(event.email, event.password);
                emit(AuthAuthenticated(user));
            } catch (e) {
                emit(AuthError(e.toString()));
            }
        });
    }
}
