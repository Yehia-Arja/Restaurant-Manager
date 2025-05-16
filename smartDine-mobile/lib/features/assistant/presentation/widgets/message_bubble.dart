import 'package:flutter/material.dart';

class MessageBubble extends StatelessWidget {
  final String content;
  final bool isUser;

  const MessageBubble({super.key, required this.content, required this.isUser});

  @override
  Widget build(BuildContext context) {
    return Align(
      alignment: isUser ? Alignment.centerRight : Alignment.centerLeft,
      child: Container(
        margin: const EdgeInsets.symmetric(vertical: 4, horizontal: 8),
        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
        decoration: BoxDecoration(
          color: isUser ? Color(0xFFFF8127) : Colors.grey.shade300,
          borderRadius: BorderRadius.circular(16),
        ),
        child: Text(content, style: TextStyle(color: isUser ? Colors.white : Colors.black)),
      ),
    );
  }
}
