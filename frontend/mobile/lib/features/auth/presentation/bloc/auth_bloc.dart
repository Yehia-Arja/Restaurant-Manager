import 'package:bloc/bloc.dart';
import '../../domain/usecases/login_usecase.dart';
import 'auth_event.dart';
import 'auth_state.dart';

class AuthBloc extends Bloc<AuthEvent, AuthState> {
    final LoginUseCase _loginUseCase;

    AuthBloc(this._loginUseCase) : super(AuthInitial()) {
        on<LoginRequested>((event, emit) async {
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
