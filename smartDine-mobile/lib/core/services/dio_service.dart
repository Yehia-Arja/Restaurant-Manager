import 'package:dio/dio.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class DioService {
  static final Dio dio = Dio(
      BaseOptions(
        baseUrl: 'http://192.168.0.200:8000/api/v0.1/',
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
