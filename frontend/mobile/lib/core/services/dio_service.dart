import 'package:dio/dio.dart';

class DioService {
    static final Dio dio = Dio(
        BaseOptions(
            baseUrl: 'http://10.0.2.2:8000/api/v0.1/',
            connectTimeout: const Duration(seconds: 10),
            receiveTimeout: const Duration(seconds: 10),
            headers: {
                'Accept': 'application/json',
            },
        ),
    );
}
