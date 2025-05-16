import 'package:dio/dio.dart';
import '../models/message_model.dart';

abstract class ChatRemoteDatasource {
  Future<MessageModel> sendMessage({required int branchId, required String message});
}

class ChatRemoteDatasourceImpl implements ChatRemoteDatasource {
  final Dio _dio;

  ChatRemoteDatasourceImpl(this._dio);

  @override
  Future<MessageModel> sendMessage({required int branchId, required String message}) async {
    final response = await _dio.post(
      'common/chat/message',
      data: {'branch_id': branchId, 'message': message},
    );

    final data = response.data;
    return MessageModel(content: data['reply'], sender: 'bot');
  }
}
