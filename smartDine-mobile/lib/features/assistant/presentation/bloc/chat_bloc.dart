import 'package:flutter_bloc/flutter_bloc.dart';
import '../../domain/entities/message.dart';
import '../../domain/usecases/get_chat_history.dart';
import '../../domain/usecases/send_message.dart';
import 'chat_event.dart';
import 'chat_state.dart';

class ChatBloc extends Bloc<ChatEvent, ChatState> {
  final GetChatHistory getChatHistory;
  final SendMessage sendMessage;

  ChatBloc({required this.getChatHistory, required this.sendMessage})
    : super(const ChatState(messages: [])) {
    on<FetchChatHistory>(_onFetchHistory);
    on<SendChatMessage>(_onSendMessage);
  }

  Future<void> _onFetchHistory(FetchChatHistory event, Emitter<ChatState> emit) async {
    emit(state.copyWith(loading: true, error: null));
    try {
      final history = await getChatHistory(event.restaurantLocationId);
      emit(state.copyWith(messages: history, loading: false));
    } catch (e) {
      emit(state.copyWith(loading: false, error: e.toString()));
    }
  }

  Future<void> _onSendMessage(SendChatMessage event, Emitter<ChatState> emit) async {
    try {
      final message = await sendMessage(
        restaurantLocationId: event.restaurantLocationId,
        message: event.message,
      );
      final updated = List<Message>.from(state.messages)..add(message);
      emit(state.copyWith(messages: updated));
    } catch (e) {
      emit(state.copyWith(error: e.toString()));
    }
  }
}
