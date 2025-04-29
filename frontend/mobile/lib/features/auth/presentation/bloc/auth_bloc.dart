import 'package:bloc/bloc.dart';
import 'package:mobile/features/auth/domain/usecases/login_usecase.dart';
import 'package:mobile/features/auth/domain/usecases/signup_usecase.dart';
import 'auth_event.dart';
import 'auth_state.dart';

class AuthBloc extends Bloc<AuthEvent, AuthState> {
  final LoginUseCase _loginUseCase;
  final SignupUseCase _signupUseCase;

  AuthBloc(this._loginUseCase, this._signupUseCase) : super(AuthInitial()) {
    on<LoginRequested>(_onLoginRequested);
    on<SignupRequested>(_onSignupRequested);
  }

  Future<void> _onLoginRequested(LoginRequested event, Emitter<AuthState> emit) async {
    if (event.email.isEmpty || event.password.isEmpty) {
      emit(const AuthError("Email and password are both required."));
      return;
    }
    emit(AuthLoading());
    try {
      final user = await _loginUseCase(email: event.email, password: event.password);
      emit(AuthAuthenticated(user));
    } catch (e) {
      emit(AuthError(e.toString()));
    }
  }

  Future<void> _onSignupRequested(SignupRequested event, Emitter<AuthState> emit) async {
    if (event.firstName.isEmpty ||
        event.lastName.isEmpty ||
        event.email.isEmpty ||
        event.password.isEmpty ||
        event.confirmPassword.isEmpty) {
      emit(AuthError("All fields are required."));
      return;
    }
    if (event.password != event.confirmPassword) {
      emit(AuthError("Passwords do not match."));
      return;
    }
    emit(AuthLoading());
    try {
      final user = await _signupUseCase(
        firstName: event.firstName,
        lastName: event.lastName,
        email: event.email,
        password: event.password,
        confirmPassword: event.confirmPassword,
      );
      emit(AuthAuthenticated(user));
    } catch (e) {
      emit(AuthError(e.toString()));
    }
  }
}
