import 'package:flutter_bloc/flutter_bloc.dart';
import '../../domain/usecases/send_message_usecase.dart';
import '../../domain/entities/message.dart';
import 'chat_event.dart';
import 'chat_state.dart';

class ChatBloc extends Bloc<ChatEvent, ChatState> {
  final SendMessageUseCase sendMessageUseCase;
  final int branchId;

  final List<Message> _messages = [];

  ChatBloc({required this.sendMessageUseCase, required this.branchId}) : super(ChatInitial()) {
    on<SendMessageEvent>(_onSendMessage);
  }

  Future<void> _onSendMessage(SendMessageEvent event, Emitter<ChatState> emit) async {
    final userMessage = Message(content: event.message, isUser: true);
    _messages.add(userMessage);
    emit(ChatLoaded(List.from(_messages)));

    try {
      final botReply = await sendMessageUseCase(branchId: branchId, message: event.message);
      _messages.add(botReply);
      emit(ChatLoaded(List.from(_messages)));
    } catch (e) {
      emit(ChatError('Failed to send message'));
    }
  }
}
