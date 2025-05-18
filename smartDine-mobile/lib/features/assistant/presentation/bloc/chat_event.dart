import 'package:equatable/equatable.dart';

abstract class ChatEvent extends Equatable {
  const ChatEvent();

  @override
  List<Object?> get props => [];
}

class FetchChatHistory extends ChatEvent {
  final int restaurantLocationId;

  const FetchChatHistory(this.restaurantLocationId);

  @override
  List<Object?> get props => [restaurantLocationId];
}

class SendChatMessage extends ChatEvent {
  final int restaurantLocationId;
  final String message;

  const SendChatMessage({required this.restaurantLocationId, required this.message});

  @override
  List<Object?> get props => [restaurantLocationId, message];
}
