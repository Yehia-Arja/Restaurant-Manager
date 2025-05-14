import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';

class SearchScreen extends StatelessWidget {
  const SearchScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final statusBar = MediaQuery.of(context).padding.top;

    return Scaffold(
      body: Padding(
        padding: EdgeInsets.fromLTRB(20, statusBar + 16, 20, 0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('Search', style: Theme.of(context).textTheme.headlineMedium),
            const SizedBox(height: 12),
            TextField(
              decoration: InputDecoration(
                hintText: 'Search...',
                prefixIcon: const Icon(Icons.search),
                filled: true,
                fillColor: AppColors.primary,
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(12),
                  borderSide: const BorderSide(color: AppColors.border),
                ),
              ),
            ),
            const SizedBox(height: 24),

            Text('Results', style: Theme.of(context).textTheme.headlineSmall),
          ],
        ),
      ),
    );
  }
}
