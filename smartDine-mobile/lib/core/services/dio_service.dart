import 'package:dio/dio.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class DioService {
  static final Dio dio = Dio(
      BaseOptions(
<<<<<<< HEAD
        baseUrl: 'http://127.0.0.1/api/v0.1/',
=======
        baseUrl: 'http://10.0.2.2/api/v0.1/',
>>>>>>> 46d00bb9747338c9e296f5cdfff9328f040e6521
        connectTimeout: const Duration(seconds: 100),
        receiveTimeout: const Duration(seconds: 100),
        headers: {'Accept': 'application/json'},
      ),
    )
    ..interceptors.add(
      InterceptorsWrapper(
        onRequest: (options, handler) async {
          final storage = FlutterSecureStorage();
          final token = await storage.read(key: 'access_token');

          if (token != null && token.isNotEmpty) {
            options.headers['Authorization'] = 'Bearer $token';
          }

          return handler.next(options);
        },
      ),
    );
}
