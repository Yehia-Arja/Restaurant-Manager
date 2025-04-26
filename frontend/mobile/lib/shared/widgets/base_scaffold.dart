import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';

class BaseScaffold extends StatelessWidget {
    final Widget child;
    final bool centerContent;

    const BaseScaffold({
        Key? key,
        required this.child,
        this.centerContent = false,
    }) : super(key: key);

    @override
    Widget build(BuildContext context) {
        return Scaffold(
            backgroundColor: AppColors.primary, // Set the background color to primary
            body: SafeArea(
                child: Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 20),
                    child: centerContent
                        ? Center(child: child)
                        : child,
                ),
            ),
        );
    }
}
