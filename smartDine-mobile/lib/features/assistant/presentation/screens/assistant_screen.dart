import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../domain/usecases/send_message_usecase.dart';
import '../bloc/chat_bloc.dart';
import '../bloc/chat_event.dart';
import '../bloc/chat_state.dart';
import '../widgets/message_bubble.dart';

class AssistantScreen extends StatefulWidget {
  final int branchId;
  final SendMessageUseCase sendMessageUseCase;

  const AssistantScreen({super.key, required this.branchId, required this.sendMessageUseCase});

  @override
  State<AssistantScreen> createState() => _AssistantScreenState();
}

class _AssistantScreenState extends State<AssistantScreen> {
  final TextEditingController _controller = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create:
          (_) => ChatBloc(sendMessageUseCase: widget.sendMessageUseCase, branchId: widget.branchId),
      child: Scaffold(
        backgroundColor: Color(0xFFFAF9F6),
        body: SafeArea(
          child: Column(
            children: [
              const Padding(
                padding: EdgeInsets.symmetric(horizontal: 20, vertical: 10),
                child: Row(
                  children: [
                    Icon(Icons.chat_bubble_outline, color: Color(0xFFFF8127)),
                    SizedBox(width: 10),
                    Text("SmartDine Assistant", style: TextStyle(fontWeight: FontWeight.bold)),
                  ],
                ),
              ),
              Expanded(
                child: BlocBuilder<ChatBloc, ChatState>(
                  builder: (context, state) {
                    if (state is ChatLoaded) {
                      return ListView.builder(
                        reverse: false,
                        itemCount: state.messages.length,
                        itemBuilder: (_, index) {
                          final msg = state.messages[index];
                          return MessageBubble(content: msg.content, isUser: msg.isUser);
                        },
                      );
                    }
                    return const Center(child: Text("Say hi to your assistant!"));
                  },
                ),
              ),
              Padding(
                padding: const EdgeInsets.all(16),
                child: Row(
                  children: [
                    Expanded(
                      child: TextField(
                        controller: _controller,
                        decoration: const InputDecoration(
                          hintText: "Message AI Assistant",
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.all(Radius.circular(30)),
                          ),
                        ),
                      ),
                    ),
                    const SizedBox(width: 10),
                    GestureDetector(
                      onTap: () {
                        final msg = _controller.text.trim();
                        if (msg.isNotEmpty) {
                          context.read<ChatBloc>().add(SendMessageEvent(msg));
                          _controller.clear();
                        }
                      },
                      child: const CircleAvatar(
                        backgroundColor: Color(0xFFFF8127),
                        child: Icon(Icons.send, color: Colors.white),
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
