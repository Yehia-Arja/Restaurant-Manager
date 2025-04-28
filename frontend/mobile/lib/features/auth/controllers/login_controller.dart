import 'package:get/get.dart';
import 'package:mobile/features/auth/data/auth_api.dart';
import 'package:mobile/features/auth/models/login_response.dart';
import 'package:mobile/features/auth/models/user_model.dart';

class LoginController extends GetxController {
    final isLoading         = false.obs;
    final isPasswordVisible = false.obs;
    final user               = Rxn<UserModel>();
    final errorMessage       = RxnString();

    @override
    void onInit() {
        super.onInit();
        ever<String?>(errorMessage, (message) {
            if (message != null) {
                Get.defaultDialog(
                    title: 'Error',
                    middleText: message,
                    textConfirm: 'OK',
                    onConfirm: () => errorMessage.value = null,
                );
            }
        });
    }

    void togglePasswordVisibility() {
        isPasswordVisible.value = !isPasswordVisible.value;
    }

    Future<void> handleSubmit(String email, String password) async {
        if (isLoading.value) return;
        if (email.isEmpty || password.isEmpty) {
            errorMessage.value = 'Please enter both email and password.';
            return;
        }

        isLoading.value    = true;
        errorMessage.value = null;

        final response = await AuthAPI.login(email: email, password: password);

        if (!response.success) {
            errorMessage.value = response.message;
        } else {
            user.value = response.user;
            Get.offAllNamed('/home');
        }

        isLoading.value = false;
    }
}
