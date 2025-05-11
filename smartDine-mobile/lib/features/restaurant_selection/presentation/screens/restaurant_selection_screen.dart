import 'package:flutter/material.dart';

class RestaurantSelectionScreen extends StatelessWidget {
  const RestaurantSelectionScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Select a Restaurant')),
      body: const Center(child: Text('Here will be the list of restaurants...')),
    );
  }
}
