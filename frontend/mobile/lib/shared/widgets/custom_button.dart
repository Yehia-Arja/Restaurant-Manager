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

        return SizedBox(
            width: double.infinity,
            height: 57,
            child: ElevatedButton(
                style: ElevatedButton.styleFrom(
                backgroundColor: backgroundColor,
                foregroundColor: textColor,
                elevation: 0,
                side: borderSide,
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                ),
                textStyle: const TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                ),
                ),
                onPressed: onPressed,
                child: iconPath != null
                    ? Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                        Image.asset(
                            iconPath!,
                            height: 20,
                        ),
                        const SizedBox(width: 8),
                        Text(text),
                        ],
                    )
                    : Text(text),
            ),
        );
    }
}
