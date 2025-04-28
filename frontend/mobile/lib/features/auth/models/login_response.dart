import 'package:frontend/mobile/lib/features/auth/models/user_model.dart';

class LoginResponse {
    final bool success;
    final String message;
    final UserModel? user;

    LoginResponse({
        required this.success,
        required this.message,
        this.user,
    });

    factory LoginResponse.fromJson(Map<String, dynamic> json) {
        return LoginResponse(
            success: json['success'] as bool,
            message: json['message'] as String,
            user: json['user'] != null
                ? UserModel.fromJson(json['user'] as Map<String, dynamic>)
                : null,
        );
    }
}
