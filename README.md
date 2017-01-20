# CGU People

**v1.0.0**

A plugin that add support for People to CGU Core themes.

Requires the [CGU Core theme](https://github.com/ObjectiveSubject/cgu-core).

#### Features Included:

- **Post Types**: People
- **Taxonomies**: Roles
- **[Shortcodes](#shortcodes)**: [[profiles]](#profiles)

---

# Shortcodes

### Profiles

`[profiles ids="" includes="" span=""]`

The profiles shortcode allows you to create profile blocks for one or more people or students.

This shortcode takes the following parameters:

Attribute | Default | Description
---|---|---
`ids` | *0* | *(required)* A comma separated list of post IDs of the people or students you'd like to display.
`includes` | *""* | *(optional)* A comma separated list of fields to display for each profile. Options include: `image`, `email`, `phone`, `website`, `cv`, `degrees`, `expertise`. If no information exists for a particular profile, it will not display. Name and Title will always display. The order in which you specify these items does not matter. The order in which they're listed here is the order in which they'll appear (note: image will display above name and title).
`span` | *4* | *(optional)* The width, in number of columns (1-12), or each profile. Use this to display a profile or group of profiles in columns.
`link_to_profile` | *true* | *(optional)* By default, a "View Profile" link is provided below each profile. Set to "false" to hide this link.

#### Examples

**Output a single profile next to a block of text**:

Place the shortcode just above the block of text it should sit next to.

`[profiles ids="4401" span="6"]`

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.

**Output profiles in a grid of 3 profiles per row**:

*Note*: for the span attribute we use the number 4 because 12/3 = 4. Since we have 12 columns in our grid, each profile should occupy 4 columns in order to display 3 profiles in each row.*

`[profiles ids="4401, 4402, 4403, 4404, 4405" span="4"]`

**Output profiles with specific information in a grid of 3 profiles per row**:

`[profiles ids="4401, 4402, 4403, 4404, 4405" span="4" includes="image, email, phone, website"]`

**Output profiles and hide the "View Profile" link**:

`[profiles ids="4401, 4402, 4403" includes="email, website" link_to_profile="false"]`
