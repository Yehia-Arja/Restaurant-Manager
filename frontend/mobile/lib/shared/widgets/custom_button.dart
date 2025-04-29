import 'dart:io';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';

class CustomButton extends StatelessWidget {
    final String text;
    final VoidCallback onPressed;
    final bool isSecondary;
    final bool isOutlined;
    final String? iconPath;

    const CustomButton({
        Key? key,
        required this.text,
        required this.onPressed,
        this.isSecondary = false,
        this.isOutlined = false,
        this.iconPath,
    }) : super(key: key);

    @override
    Widget build(BuildContext context) {
        final screenWidth = MediaQuery.of(context).size.width;
        final screenHeight = MediaQuery.of(context).size.height;

        final buttonWidth = screenWidth * 0.9;
        final buttonHeight = screenHeight * 0.07;

        Color backgroundColor = AppColors.accent;
        Color textColor = Colors.white;
        BorderSide borderSide = BorderSide.none;

        if (isSecondary) {
            backgroundColor = AppColors.secondary;
        }

        if (isOutlined) {
            backgroundColor = Colors.transparent;
            textColor = AppColors.secondary;
            borderSide = BorderSide(color: AppColors.border);
        }

        final Widget childContent = iconPath != null
            ? Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                    Image.asset(
                        iconPath!,
                        height: buttonHeight * 0.4,
                    ),
                    const SizedBox(width: 8),
                    Text(
                        text,
                        style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                            fontSize: buttonHeight * 0.3,
                            fontWeight: FontWeight.bold,
                            color: textColor,
                        ),
                    ),
                ],
            )
            : Text(
                text,
                style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                    fontSize: buttonHeight * 0.3,
                    fontWeight: FontWeight.bold,
                    color: textColor,
                ),
            );

        return SizedBox(
            width: buttonWidth,
            height: buttonHeight,
            child: Platform.isIOS
                ? CupertinoButton(
                    color: backgroundColor,
                    padding: EdgeInsets.zero,
                    borderRadius: BorderRadius.circular(buttonHeight * 0.25),
                    onPressed: onPressed,
                    child: childContent,
                )
                : ElevatedButton(
                    style: ElevatedButton.styleFrom(
                        backgroundColor: backgroundColor,
                        foregroundColor: textColor,
                        elevation: 0,
                        side: borderSide,
                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(buttonHeight * 0.25),
                        ),
                    ),
                    onPressed: onPressed,
                    child: childContent,
                ),
        );
    }
}
