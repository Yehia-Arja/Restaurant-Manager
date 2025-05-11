import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/features/restaurant_selection/domain/entities/restaurant.dart';

class RestaurantCard extends StatelessWidget {
  final Restaurant restaurant;
  final VoidCallback? onFavoritePressed;

  const RestaurantCard({super.key, required this.restaurant, this.onFavoritePressed});

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.symmetric(vertical: 6),
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        color: Colors.white,
        boxShadow: const [BoxShadow(color: Colors.black12, blurRadius: 6, offset: Offset(0, 2))],
      ),
      child: Row(
        children: [
          // Restaurant image with fallback
          ClipRRect(
            borderRadius: BorderRadius.circular(8),
            child: Image.network(
              restaurant.imageUrl.startsWith('http')
                  ? restaurant.imageUrl
                  : 'https://placehold.co/60x60.png',
              width: 60,
              height: 60,
              fit: BoxFit.cover,
              errorBuilder:
                  (_, __, ___) => Container(
                    width: 60,
                    height: 60,
                    color: Colors.grey[200],
                    alignment: Alignment.center,
                    child: const Icon(Icons.image_not_supported, color: Colors.grey),
                  ),
            ),
          ),
          const SizedBox(width: 12),

          // Name and description
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  restaurant.name,
                  style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                    fontWeight: FontWeight.bold,
                    color: AppColors.secondary,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  restaurant.description ?? 'No description',
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: Theme.of(context).textTheme.bodySmall?.copyWith(color: AppColors.label),
                ),
              ],
            ),
          ),

          // Favorite (heart) icon
          IconButton(
            icon: const Icon(Icons.favorite_border, color: AppColors.accent),
            onPressed: onFavoritePressed,
          ),
        ],
      ),
    );
  }
}
