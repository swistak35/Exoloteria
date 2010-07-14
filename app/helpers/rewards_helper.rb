module RewardsHelper
  def count_chances(reward)
    quantity = 0 if @fraction == ''
    quantity = reward.ally if @fraction == 'ally'
    quantity = reward.horda if @fraction == 'horda'
    quantity = 10 if quantity > 10
    return ((reward.rate * quantity * 100) / @quantity)
  end
  
  def show_buttons(reward)
    if @fraction == ''
      return ", #{link_to 'Edytuj', edit_reward_path(reward)}, #{link_to 'Usun', reward, :confirm => 'Jestes pewien?', :method => :delete}"
    else
      return ""
    end
  end
end
