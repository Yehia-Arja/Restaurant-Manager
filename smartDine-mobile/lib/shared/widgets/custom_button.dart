import 'dart:io';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';

class CustomButton extends StatelessWidget {
  // Either text or child must be non-null
  final String? text;
  final Widget? child;

  // Disabled when null
  final VoidCallback? onPressed;
  final bool isSecondary;
  final bool isOutlined;
  final String? iconPath;

  const CustomButton({
    super.key,
    this.text,
    this.child,
    required this.onPressed,
    this.isSecondary = false,
    this.isOutlined = false,
    this.iconPath,
  }) : assert(
         text != null || child != null,
         'Either text or child must be provided',
       );

  @override
  Widget build(BuildContext context) {
    // Build the inner content
    final content =
        child ??
        (iconPath != null
            ? Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Image.asset(iconPath!, height: 20),
                const SizedBox(width: 8),
                Text(text!),
              ],
            )
            : Text(text!));

    // Material button: rely on theme, override only when secondary or outlined
    if (!Platform.isIOS) {
      final baseStyle = Theme.of(context).elevatedButtonTheme.style;
      ButtonStyle? style = baseStyle;

      if (isSecondary) {
        style = baseStyle?.copyWith(
          backgroundColor: WidgetStateProperty.all(AppColors.secondary),
        );
      } else if (isOutlined) {
        style = baseStyle?.copyWith(
          backgroundColor: WidgetStateProperty.all(Colors.transparent),
          side: WidgetStateProperty.all(BorderSide(color: AppColors.border)),
          foregroundColor: WidgetStateProperty.all(AppColors.secondary),
        );
      }

      return SizedBox(
        width: double.infinity,
        child: ElevatedButton(
          style: style,
          onPressed: onPressed,
          child: content,
        ),
      );
    }

    // Cupertino button
    Color bg = isSecondary ? AppColors.secondary : AppColors.accent;
    final childContent = content;
    return SizedBox(
      width: double.infinity,
      child: CupertinoButton(
        color: bg,
        borderRadius: BorderRadius.circular(8),
        padding: EdgeInsets.symmetric(vertical: 16),
        onPressed: onPressed,
        child: childContent,
      ),
    );
  }
}
