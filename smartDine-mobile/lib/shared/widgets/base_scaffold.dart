import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';

class BaseScaffold extends StatelessWidget {
  final Widget child;
  final bool centerContent;
  final Widget? bottomNavigationBar;

  const BaseScaffold({
    super.key,
    required this.child,
    this.centerContent = false,
    this.bottomNavigationBar,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.primary,
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: centerContent ? Center(child: child) : child,
        ),
      ),
      bottomNavigationBar: bottomNavigationBar,
    );
  }
}
