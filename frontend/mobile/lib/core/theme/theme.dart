import 'package:flutter/material.dart';
import 'colors.dart';

class AppTheme {
    static ThemeData get lightTheme {
        return ThemeData(
            scaffoldBackgroundColor: AppColors.primary,
            primaryColor: AppColors.primary,
            fontFamily: 'Poppins',

            appBarTheme: const AppBarTheme(
                backgroundColor: AppColors.accent,
                foregroundColor: Colors.white,
                elevation: 0,
            ),

            textTheme:TextTheme(
                headlineLarge: TextStyle(
                    fontSize: 32,
                    fontWeight: FontWeight.bold,
                    color: AppColors.secondary,
                ),
                headlineMedium: TextStyle(
                    fontSize: 22,
                    fontWeight: FontWeight.w600,
                    color: AppColors.secondary,
                ),
                bodyLarge: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.normal,
                    color: AppColors.secondary,
                ),
                bodyMedium: TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.normal,
                    color: AppColors.secondary,
                ),
                bodySmall: TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.normal,
                    color: AppColors.secondary,
                ),
            ),

            elevatedButtonTheme: ElevatedButtonThemeData(
                style: ElevatedButton.styleFrom(
                    backgroundColor: AppColors.accent,   // orange
                    foregroundColor: Colors.white,       // button text color
                    textStyle: const TextStyle(           // button text style
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    ),
                    minimumSize: const Size(double.infinity, 57), // full width and height
                    shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),    // rounded border
                    ),
                    elevation: 0,   // flat buttons, no ugly shadow
                ),
            ),

            inputDecorationTheme: InputDecorationTheme(
                hintStyle: TextStyle(color: AppColors.placeholder),
                enabledBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12),
                    borderSide: BorderSide(color: AppColors.border),
                ),
                focusedBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12),
                    borderSide: BorderSide(color: AppColors.accent),
                ),
            ),

            dividerColor: AppColors.border,
        );
    }
}