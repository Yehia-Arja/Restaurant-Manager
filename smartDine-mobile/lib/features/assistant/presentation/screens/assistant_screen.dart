import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/shared/widgets/base_scaffold.dart';
import 'package:mobile/features/assistant/presentation/bloc/chat_bloc.dart';
import 'package:mobile/features/assistant/presentation/bloc/chat_event.dart';
import 'package:mobile/features/assistant/presentation/bloc/chat_state.dart';
import 'package:mobile/features/assistant/domain/usecases/send_message_usecase.dart';
import 'package:mobile/features/assistant/domain/entities/message.dart';

class AssistantScreen extends StatefulWidget {
  final int branchId;
  final SendMessage sendMessageUseCase;

  const AssistantScreen({Key? key, required this.branchId, required this.sendMessageUseCase})
    : super(key: key);

  @override
  State<AssistantScreen> createState() => _AssistantScreenState();
}

class _AssistantScreenState extends State<AssistantScreen> {
  final TextEditingController _controller = TextEditingController();
  final ScrollController _scroll = ScrollController();
  bool _showLoadingBubble = false;
  List<Message> _pendingMessages = [];

  void _sendMessage() {
    final text = _controller.text.trim();
    if (text.isEmpty) return;

    final pendingMessage = Message(
      id: -1,
      content: text,
      senderType: 'user',
      createdAt: DateTime.now(),
    );

    setState(() {
      _pendingMessages.add(pendingMessage);
      _showLoadingBubble = true;
    });

    context.read<ChatBloc>().add(
      SendChatMessage(restaurantLocationId: widget.branchId, message: text),
    );

    _controller.clear();

    Future.delayed(const Duration(milliseconds: 200), () {
      if (_scroll.hasClients) {
        _scroll.animateTo(
          _scroll.position.maxScrollExtent,
          duration: const Duration(milliseconds: 300),
          curve: Curves.easeOut,
        );
      }
    });
  }

  @override
  void initState() {
    super.initState();
    context.read<ChatBloc>().add(FetchChatHistory(widget.branchId));
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        SafeArea(
          child: Container(
            width: double.infinity,
            padding: const EdgeInsets.all(16),
            color: AppColors.accent.withOpacity(0.1),
            child: Row(
              children: [
                const Icon(Icons.smart_toy, color: AppColors.accent),
                const SizedBox(width: 8),
                Text(
                  "SmartDine Assistant",
                  style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                    fontWeight: FontWeight.w600,
                    color: AppColors.secondary,
                  ),
                ),
              ],
            ),
          ),
        ),
        Expanded(
          child: BaseScaffold(
            child: Column(
              children: [
                Expanded(
                  child: BlocConsumer<ChatBloc, ChatState>(
                    listener: (context, state) {
                      if (_scroll.hasClients) {
                        Future.delayed(const Duration(milliseconds: 300), () {
                          _scroll.animateTo(
                            _scroll.position.maxScrollExtent,
                            duration: const Duration(milliseconds: 300),
                            curve: Curves.easeOut,
                          );
                        });
                      }
                      if (!state.loading) {
                        setState(() {
                          _showLoadingBubble = false;
                          _pendingMessages.clear();
                        });
                      }
                    },
                    builder: (context, state) {
                      final messages = [...state.messages, ..._pendingMessages];

                      if (messages.isEmpty) {
                        return const Center(
                          child: Text(
                            "Talk to your Assistant now",
                            style: TextStyle(color: AppColors.placeholder, fontSize: 16),
                          ),
                        );
                      }

                      return ListView.builder(
                        controller: _scroll,
                        padding: const EdgeInsets.all(16),
                        itemCount: messages.length + (_showLoadingBubble ? 1 : 0),
                        itemBuilder: (_, index) {
                          if (_showLoadingBubble && index == messages.length) {
                            return Align(
                              alignment: Alignment.centerLeft,
                              child: Container(
                                margin: const EdgeInsets.symmetric(vertical: 6),
                                padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 10),
                                decoration: BoxDecoration(
                                  color: AppColors.border,
                                  borderRadius: BorderRadius.circular(16),
                                ),
                                child: const SizedBox(
                                  height: 16,
                                  width: 32,
                                  child: Row(
                                    mainAxisSize: MainAxisSize.min,
                                    children: [Dot(), Dot(delay: 100), Dot(delay: 200)],
                                  ),
                                ),
                              ),
                            );
                          }

                          final msg = messages[index];
                          final isAI = msg.senderType == 'ai';

                          return Align(
                            alignment: isAI ? Alignment.centerLeft : Alignment.centerRight,
                            child: Container(
                              margin: const EdgeInsets.symmetric(vertical: 6),
                              padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 10),
                              constraints: BoxConstraints(
                                maxWidth: MediaQuery.of(context).size.width * 0.75,
                              ),
                              decoration: BoxDecoration(
                                color: isAI ? AppColors.border : AppColors.accent.withOpacity(0.9),
                                borderRadius: BorderRadius.circular(16),
                              ),
                              child: Text(
                                msg.content,
                                style: TextStyle(color: isAI ? AppColors.secondary : Colors.white),
                              ),
                            ),
                          );
                        },
                      );
                    },
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                  child: TextField(
                    controller: _controller,
                    onSubmitted: (_) => _sendMessage(),
                    decoration: InputDecoration(
                      hintText: 'Message AI Assistant',
                      hintStyle: const TextStyle(color: AppColors.placeholder),
                      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                      filled: true,
                      fillColor: Colors.white,
                      suffixIcon: IconButton(
                        icon: const Icon(Icons.send, color: AppColors.accent),
                        onPressed: _sendMessage,
                      ),
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(24),
                        borderSide: BorderSide.none,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }
}

class Dot extends StatelessWidget {
  final int delay;
  const Dot({super.key, this.delay = 0});

  @override
  Widget build(BuildContext context) {
    return AnimatedPadding(
      duration: Duration(milliseconds: 300 + delay),
      padding: const EdgeInsets.symmetric(horizontal: 1.5),
      child: const CircleAvatar(radius: 3, backgroundColor: AppColors.placeholder),
    );
  }
}
