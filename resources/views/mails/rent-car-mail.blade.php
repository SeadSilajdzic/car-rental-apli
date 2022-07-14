Hello {{ $user->name }}. <br>
Thank you for trusting us and using our car-rental services. <br>

You have rented a car with {{ $rent->registration_license }} registration license for {{ $rent->date_range }} days ({{ $rent->date_from }} / {{ $rent->date_to }}). <br>
Total cost of this rent is ${{ $rent->total_rent_price }}. <br>

Sincerely,
car-rental company
