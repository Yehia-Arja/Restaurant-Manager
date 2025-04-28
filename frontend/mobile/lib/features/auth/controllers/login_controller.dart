import 'package:get/get.dart';
import 'package:mobile/features/auth/data/auth_api.dart';
import 'package:mobile/features/auth/models/user_model.dart';

class LoginController extends GetxController {
    final isLoading         = false.obs;
    final isPasswordVisible = false.obs;
    final user               = Rxn<UserModel>();
    final errorMessage       = RxnString();

    void togglePasswordVisibility() =>
        isPasswordVisible.value = !isPasswordVisible.value;

    Future<void> handleSubmit(String email, String password) async {
        if (isLoading.value) return;

        if (email.isEmpty || password.isEmpty) {
            errorMessage.value = 'Please enter both email and password.';
            return;
        }

        isLoading.value    = true;
        errorMessage.value = null;

        final resppnse = await AuthAPI.login(email: email, password: password);

        if (!response['success'] as bool) {
            // Show exactly the backend’s message
            errorMessage.value = resp['message'] as String;
        } else {
            // Success path
            final userJson = response['user'] as Map<String, dynamic>;
            user.value = UserModel.fromJson(userJson);
            Get.offAllNamed('/home');
        }

        isLoading.value = false;
    }
}