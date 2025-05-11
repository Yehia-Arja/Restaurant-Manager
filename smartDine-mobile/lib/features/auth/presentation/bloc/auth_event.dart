abstract class AuthEvent {}

class LoginRequested extends AuthEvent {
  final String email, password;
  LoginRequested(this.email, this.password);
}

class SignupRequested extends AuthEvent {
  final String firstName, lastName, email, password, confirmPassword;
  SignupRequested(this.firstName, this.lastName, this.email, this.password, this.confirmPassword);
}
